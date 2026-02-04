<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminService
{
    public function getAllUsersWithBalances(int $perPage = 15)
    {
        return User::where('role', 'user')
            ->withCount(['transactions as deposit_count' => function ($query) {
                $query->where('type', 'deposit');
            }])
            ->withCount(['transactions as withdrawal_count' => function ($query) {
                $query->where('type', 'withdrawal');
            }])
            ->paginate($perPage);
    }

    public function getUserTransactionLogs(User $user, int $perPage = 15)
    {
        return $user->transactionLogs()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getFailedWithdrawals(int $perPage = 15)
    {
        return TransactionLog::with('user')
            ->where('type', 'withdrawal')
            ->where('status', 'failed')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getDailySummary(?Carbon $date = null)
    {
        $date = $date ?? Carbon::today();

        $totalDeposits = Transaction::where('type', 'deposit')
            ->whereDate('created_at', $date)
            ->sum('amount');

        $totalWithdrawals = Transaction::where('type', 'withdrawal')
            ->whereDate('created_at', $date)
            ->sum('amount');

        $depositCount = Transaction::where('type', 'deposit')
            ->whereDate('created_at', $date)
            ->count();

        $withdrawalCount = Transaction::where('type', 'withdrawal')
            ->whereDate('created_at', $date)
            ->count();

        $failedWithdrawals = TransactionLog::where('type', 'withdrawal')
            ->where('status', 'failed')
            ->whereDate('created_at', $date)
            ->count();

        $activeUsers = Transaction::whereDate('created_at', $date)
            ->distinct('user_id')
            ->count('user_id');

        return [
            'date' => $date->toDateString(),
            'total_deposits' => (float) $totalDeposits,
            'total_withdrawals' => (float) $totalWithdrawals,
            'deposit_count' => $depositCount,
            'withdrawal_count' => $withdrawalCount,
            'failed_withdrawals' => $failedWithdrawals,
            'net_flow' => (float) ($totalDeposits - $totalWithdrawals),
            'active_users' => $activeUsers,
        ];
    }

    public function getDashboardStats()
    {
        $totalUsers = User::where('role', 'user')->count();
        $activeUsers = User::where('role', 'user')->where('is_active', true)->count();

        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');

        $todaySummary = $this->getDailySummary();

        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'total_deposits' => (float) $totalDeposits,
            'total_withdrawals' => (float) $totalWithdrawals,
            'system_balance' => (float) ($totalDeposits - $totalWithdrawals),
            'today' => $todaySummary,
        ];
    }

    public function getAllTransactions(int $perPage = 15)
    {
        return Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getTransactionsByDateRange(Carbon $startDate, Carbon $endDate, int $perPage = 15)
    {
        return Transaction::with('user')
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
