<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Change these demo passwords immediately after first login.
        $users = [
            ['name' => 'G4Mart Manager', 'email' => 'manager@g4mart.test', 'role' => 'manager'],
            ['name' => 'G4Mart Cashier', 'email' => 'cashier@g4mart.test', 'role' => 'cashier'],
            ['name' => 'G4Mart Clerk', 'email' => 'clerk@g4mart.test', 'role' => 'clerk'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => Hash::make('ChangeMe123!'),
                ]
            );
        }
    }
}
