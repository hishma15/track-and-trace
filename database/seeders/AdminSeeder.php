<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // Check if an admin with username 'admin' exists
        $admin = User::where('username', 'admin')->first();

        if ($admin) {
            // Update existing admin
            $admin->update([
                'email' => 'trackntrace14@gmail.com',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone_no' => '0771234567',
                'password' => Hash::make('Admin@123'),
                'role' => 'Admin',
            ]);
        } else {
            // Create new admin
            User::create([
                'email' => 'trackntrace14@gmail.com',
                'username' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone_no' => '0771234567',
                'password' => Hash::make('Admin@123'),
                'role' => 'Admin',
            ]);
        }

        // User::updateOrCreate(
        //     [
        //         'email' => 'trackntrace14@gmail.com',
        //         'username' => 'admin'
        //     ], 
        //     [
        //         'first_name' => 'Admin',
        //         'last_name' => 'User',
        //         'phone_no' => '0771234567',
        //         'password' => Hash::make('Admin@123'),
        //         'role' => 'Admin',
        //     ]
        // );

    }
}
