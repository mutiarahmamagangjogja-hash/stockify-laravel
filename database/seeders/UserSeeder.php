<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'admin@stockify.test',
            ],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | MANAGER GUDANG
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'manager@stockify.test',
            ],
            [
                'name' => 'Manager Gudang',
                'password' => Hash::make('password'),
                'role' => 'manager_gudang',
                'status' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | STAFF GUDANG
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'staff@stockify.test',
            ],
            [
                'name' => 'Staff Gudang',
                'password' => Hash::make('password'),
                'role' => 'staff_gudang',
                'status' => true,
            ]
        );
    }
}