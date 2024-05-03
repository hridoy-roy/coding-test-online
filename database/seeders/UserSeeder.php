<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'Individual User',
            'account_type'      => 'individual',
            'balance'           => 0,
            'email'             => 'individual@mail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('12345678'),
        ]);

        User::create([
            'name'              => 'Business User',
            'account_type'      => 'business',
            'balance'           => 0,
            'email'             => 'business@mail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('12345678'),
        ]);
    }
}
