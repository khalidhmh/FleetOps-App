<?php

/**
 * @file UserSeeder.php
 * @description Seed baseline users for all system roles
 * @module AuthIdentity
 * @author Team Leader (Khalid)
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\AuthIdentity\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Uses updateOrCreate to be idempotent — safe to run multiple times.
     */
    public function run(): void
    {
        $users = [
            // 1. مدير الأسطول (Fleet Manager / Admin)
            [
                'name'      => 'Admin',
                'email'     => 'admin@fleetops.com',
                'password'  => Hash::make('password123'),
                'phone_no'  => '01000000001',
                'role'      => 'FleetManager',
                'is_active' => true,
            ],
            // 2. سائق (Driver)
            [
                'name'      => 'Ahmed Driver',
                'email'     => 'driver@fleetops.com',
                'password'  => Hash::make('password123'),
                'phone_no'  => '01000000002',
                'role'      => 'Driver',
                'is_active' => true,
            ],
            // 3. ميكانيكي (Mechanic)
            [
                'name'      => 'Mohamed Mechanic',
                'email'     => 'mechanic@fleetops.com',
                'password'  => Hash::make('password123'),
                'phone_no'  => '01000000003',
                'role'      => 'Mechanic',
                'is_active' => true,
            ],
            // 4. موزع (Dispatcher)
            [
                'name'      => 'Youssef Dispatcher',
                'email'     => 'dispatcher@fleetops.com',
                'password'  => Hash::make('password123'),
                'phone_no'  => '01000000004',
                'role'      => 'Dispatcher',
                'is_active' => true,
            ],
            // 5. عميل (Customer)
            [
                'name'      => 'Client Company',
                'email'     => 'customer@fleetops.com',
                'password'  => Hash::make('password123'),
                'phone_no'  => '01000000005',
                'role'      => 'Customer',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],   // match key
                $userData                          // data to insert or update
            );
        }

        $this->command->info('✅ UserSeeder: ' . count($users) . ' users seeded successfully.');
    }
}