<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'User1', 'email' => 'user1@example.com'],
            ['name' => 'User2', 'email' => 'user2@example.com'],
            ['name' => 'User3', 'email' => 'user3@example.com'],
            ['name' => 'User4', 'email' => 'user4@example.com'],
            ['name' => 'User5', 'email' => 'user5@example.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('todo123'),
            ]);
        }
    }
}
