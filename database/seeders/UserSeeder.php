<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            User::truncate();
        });

        User::insert(
            [
                [
                    'username' => 'admin',
                    'name' => 'admin',
                    'surname' => 'admin',
                    'email' => 'admin@example.com',
                    'password' => Hash::make('admin'),
                    'avatar' => '',
                    'role' => 'admin'
                ],
                [
                    'username' => 'paulina123',
                    'name' => 'Paulina',
                    'surname' => 'Radzymińska',
                    'email' => 'paulina@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'female.jpg',
                    'role' => 'user'
                ],
                [
                    'username' => 'adrian456',
                    'name' => 'Adrian',
                    'surname' => 'Potocki',
                    'email' => 'adrian@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'male.jpg',
                    'role' => 'user'
                ],
                [
                    'username' => 'tom',
                    'name' => 'Tomasz',
                    'surname' => 'Kowalski',
                    'email' => 'tomasz@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'male.jpg',
                    'role' => 'user'
                ],
                [
                    'username' => 'felix',
                    'name' => 'Feliks',
                    'surname' => 'Oberżyński',
                    'email' => 'felix@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'male.jpg',
                    'role' => 'user'
                ],
                [
                    'username' => 'kryst1',
                    'name' => 'Krystian',
                    'surname' => 'Komarewski',
                    'email' => 'kryst@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'male.jpg',
                    'role' => 'user'
                ],
                [
                    'username' => 'aga09',
                    'name' => 'Agnieszka',
                    'surname' => 'Prucnal',
                    'email' => 'agi@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'female.jpg',
                    'role' => 'user'
                ],
                [
                    'username' => 'rafalek5',
                    'name' => 'Rafał',
                    'surname' => 'Kamiński',
                    'email' => 'rafal@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'male.jpg',
                    'role' => 'user'
                ],
                [
                    'username' => 'klaudia80',
                    'name' => 'Klaudia',
                    'surname' => 'Puzio',
                    'email' => 'klaudia@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'female.jpg',
                    'role' => 'user'
                ],
                [
                    'username' => 'zaneta25',
                    'name' => 'Żaneta',
                    'surname' => 'Skarbowicz',
                    'email' => 'zaneta@example.com',
                    'password' => Hash::make('123'),
                    'avatar' => 'female.jpg',
                    'role' => 'user'
                ]
            ]
        );
    }
}
