<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin2@example.com',
            'password' => Hash::make('abc'), // Change this in production
            'role' => 'admin', // if you use is_admin flag
            'country' => 'India', // Example country
            'remember_token' => Str::random(10),
        ]);
    }
}
