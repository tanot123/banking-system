<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function deposit(User $user, float $amount, ?string $description = null, ?string $ipAddress = null): array
    {
        return DB::transaction(function () use ($user, $amount, $description, $ipAddress) {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type' => 'deposit',
                'amount' => $amount,
                'reference_number' => Transaction::generateReferenceNumber(),
                'description' => $description,
            ]);

            TransactionLog::create([
                'user_id' => $user->id,
                'type' => 'deposit',
                'amount' => $amount,
                'status' => 'success',
                'ip_address' => $ipAddress,
            ]);

            return [
                'success' => true,
                'transaction' => $transaction,
                'new_balance' => $user->fresh()->balance,
            ];
        });
    }

    public function withdraw(User $user, float $amount, ?string $description = null, ?string $ipAddress = null): array
    {
        $validationResult = $this->validateWithdrawal($user, $amount);

        if (!$validationResult['valid']) {
            TransactionLog::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'status' => 'failed',
                'failure_reason' => $validationResult['reason'],
                'ip_address' => $ipAddress,
            ]);

            return [
                'success' => false,
                'message' => $validationResult['reason'],
            ];
        }

        return DB::transaction(function () use ($user, $amount, $description, $ipAddress) {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'reference_number' => Transaction::generateReferenceNumber(),
                'description' => $description,
            ]);

            TransactionLog::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'status' => 'success',
                'ip_address' => $ipAddress,
            ]);

            return [
                'success' => true,
                'transaction' => $transaction,
                'new_balance' => $user->fresh()->balance,
            ];
        });
    }

    private function validateWithdrawal(User $user, float $amount): array
    {
        $maxDailyWithdrawals = config('banking.max_daily_withdrawals', 3);
        $maxDailyAmount = config('banking.max_daily_withdrawal_amount', 5000);

        if ($amount <= 0) {
            return ['valid' => false, 'reason' => 'Amount must be greater than zero'];
        }

        if ($user->balance < $amount) {
            return ['valid' => false, 'reason' => 'Insufficient balance'];
        }

        if ($user->today_withdrawal_count >= $maxDailyWithdrawals) {
            return ['valid' => false, 'reason' => "Maximum daily withdrawal limit reached ({$maxDailyWithdrawals} withdrawals per day)"];
        }

        if (($user->today_withdrawal_amount + $amount) > $maxDailyAmount) {
            $remaining = $maxDailyAmount - $user->today_withdrawal_amount;
            return ['valid' => false, 'reason' => "Daily withdrawal amount limit exceeded. Remaining limit: {$remaining}"];
        }

        return ['valid' => true, 'reason' => null];
    }

    public function getTransactionHistory(User $user, int $perPage = 15)
    {
        return $user->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
