<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'account_number' => 'ATM0000000001',
            'name' => 'Admin User',
            'email' => 'admin@atm.com',
            'password' => Hash::make('password'),
            'pin' => Hash::make('123456'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $user = User::create([
            'account_number' => User::generateAccountNumber(),
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'pin' => Hash::make('123456'),
            'role' => 'user',
            'is_active' => true,
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'amount' => 10000,
            'reference_number' => Transaction::generateReferenceNumber(),
            'description' => 'Initial deposit',
        ]);
    }
}
