<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['deposit', 'withdrawal']),
            'amount' => fake()->randomFloat(2, 100, 5000),
            'reference_number' => Transaction::generateReferenceNumber(),
            'description' => fake()->optional()->sentence(),
        ];
    }

    public function deposit(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'deposit',
        ]);
    }

    public function withdrawal(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'withdrawal',
        ]);
    }
}
