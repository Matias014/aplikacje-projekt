<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class DatabaseBackupCommand extends Command
{
    protected $signature = 'backup:db {--keep=30}';
    protected $description = 'Create a compressed MySQL dump and keep N days of backups';

    public function handle(): int
    {
        $conn = config('database.connections.mysql');

        $user = (string)($conn['username'] ?? '');
        $pass = (string)($conn['password'] ?? '');
        $host = (string)($conn['host'] ?? '127.0.0.1');
        $port = (int)($conn['port'] ?? 3306);
        $db = (string)($conn['database'] ?? '');

        if ($user === '' || $db === '') {
            $this->error('Missing database configuration (DB_USERNAME / DB_DATABASE).');
            return self::FAILURE;
        }

        $dir = storage_path('app/backups');
        File::ensureDirectoryExists($dir);

        $gzPath = $dir . DIRECTORY_SEPARATOR . 'backup_' . now()->format('Ymd_His') . '.sql.gz';

        $args = [
            'mysqldump',
            '--host=' . $host,
            '--port=' . $port,
            '--user=' . $user,
            '--no-tablespaces',
            '--single-transaction',
            '--routines',
            '--events',
            '--triggers',
            $db,
        ];

        $env = null;
        if ($pass !== '') {
            $env = array_merge($_SERVER, $_ENV, ['MYSQL_PWD' => $pass]);
        }

        $gz = @gzopen($gzPath, 'wb9');
        if ($gz === false) {
            $this->error('Cannot create backup file: ' . $gzPath);
            return self::FAILURE;
        }

        $process = new Process($args, null, $env);
        $process->setTimeout(3600);

        $process->run(function (string $type, string $buffer) use ($gz) {
            if ($type === Process::OUT && $buffer !== '') {
                gzwrite($gz, $buffer);
            }
        });

        gzclose($gz);

        if (!$process->isSuccessful()) {
            @File::delete($gzPath);
            $this->error(trim($process->getErrorOutput()) ?: 'mysqldump failed');
            return self::FAILURE;
        }

        $keepDays = max(0, (int)$this->option('keep'));
        if ($keepDays > 0) {
            $cutoff = now()->subDays($keepDays)->getTimestamp();
            foreach (File::files($dir) as $file) {
                if ($file->getMTime() < $cutoff) {
                    @File::delete($file->getPathname());
                }
            }
        }

        return self::SUCCESS;
    }
}
