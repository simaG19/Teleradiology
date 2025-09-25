<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        // Only run if role column exists
        if (!Schema::hasColumn('users', 'role')) {
            $this->command->info('Role column does not exist. Run the migration first.');
            return;
        }

        // Update existing users or create new ones
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Reader User',
                'email' => 'reader@example.com',
                'password' => Hash::make('password'),
                'role' => 'reader',
            ],
            [
                'name' => 'Hospital User',
                'email' => 'hospital@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'hospital',
            ],
        ];

        foreach ($users as $userData) {
            DB::table('users')->updateOrInsert(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('User roles seeded successfully.');
    }
}
