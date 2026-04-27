<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('vehicles')->insert([
            'vehicle_brand' => 'Toyota Hilux',
            'vehicle_license' => 'ABC-123',
            'max_weight_capacity' => 1500.00,
            'fuel_type' => 'Diesel',
            'status' => 'Active',
            'current_odometer' => 5000,
            'created_at' => now(),
        ]);
    }
}
