<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء مدير نظام
        \App\Modules\AuthIdentity\Models\User::factory()->create([
            'name' => 'Khalid Admin',
            'email' => 'admin@fleetops.com',
            'role' => 'FleetManager',
        ]);
        // إنشاء 10 سائقين وهميين للتجارب
        \App\Modules\AuthIdentity\Models\User::factory(10)->create(['role' => 'Driver']);
    }
}
