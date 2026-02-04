<?php

namespace Database\Factories;

use App\Models\TransactionLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionLogFactory extends Factory
{
    protected $model = TransactionLog::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['deposit', 'withdrawal']),
            'amount' => fake()->randomFloat(2, 100, 5000),
            'status' => 'success',
            'failure_reason' => null,
            'ip_address' => fake()->ipv4(),
        ];
    }

    public function failed(string $reason = 'Insufficient balance'): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'failure_reason' => $reason,
        ]);
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
