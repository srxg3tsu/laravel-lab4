<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Администратор
        User::create([
            'name' => 'Администратор',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Обычные пользователи
        User::create([
            'name' => 'Никита',
            'username' => 'nikita',
            'email' => 'nikita@test.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Иван',
            'username' => 'ivan',
            'email' => 'ivan@test.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}