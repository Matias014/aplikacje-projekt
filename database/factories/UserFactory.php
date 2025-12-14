<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password = null;

    public function definition(): array
    {
        $username = Str::of($this->faker->unique()->userName())
            ->replaceMatches('/[^a-zA-Z0-9_]/', '')
            ->substr(0, 20)
            ->toString();

        if ($username === '') {
            $username = Str::random(12);
        }

        return [
            'username' => $username,
            'name' => Str::of($this->faker->firstName())->substr(0, 20)->toString(),
            'surname' => Str::of($this->faker->lastName())->substr(0, 25)->toString(),
            'email' => Str::of($this->faker->unique()->safeEmail())->substr(0, 60)->toString(),
            'password' => static::$password ??= Hash::make('password'),
            'avatar' => null,
            'role' => 'user',
        ];
    }

    public function admin(): static
    {
        return $this->state(fn() => ['role' => 'admin']);
    }
}
