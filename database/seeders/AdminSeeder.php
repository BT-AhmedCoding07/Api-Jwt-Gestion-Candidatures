<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "nom" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make('azertyuiop'),
            "role" => "Admin",
            "telephone" => 772889673
        ]);
    }
}
