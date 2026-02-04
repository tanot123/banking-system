<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct(
        private AdminService $adminService
    ) {}

    public function dashboard()
    {
        $stats = $this->adminService->getDashboardStats();

        return response()->json([
            'stats' => $stats,
        ]);
    }

    public function users(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $users = $this->adminService->getAllUsersWithBalances($perPage);

        $formattedUsers = collect($users->items())->map(function ($user) {
            return [
                'id' => $user->id,
                'account_number' => $user->account_number,
                'name' => $user->name,
                'email' => $user->email,
                'balance' => $user->balance,
                'is_active' => $user->is_active,
                'deposit_count' => $user->deposit_count,
                'withdrawal_count' => $user->withdrawal_count,
                'created_at' => $user->created_at,
            ];
        });

        return response()->json([
            'users' => $formattedUsers,
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ],
        ]);
    }

    public function userDetail(User $user)
    {
        return response()->json([
            'user' => [
                'id' => $user->id,
                'account_number' => $user->account_number,
                'name' => $user->name,
                'email' => $user->email,
                'balance' => $user->balance,
                'is_active' => $user->is_active,
                'created_at' => $user->created_at,
            ],
        ]);
    }

    public function userTransactions(Request $request, User $user)
    {
        $perPage = $request->get('per_page', 15);
        $transactions = $user->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'account_number' => $user->account_number,
                'name' => $user->name,
            ],
            'transactions' => $transactions->items(),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }

    public function userLogs(Request $request, User $user)
    {
        $perPage = $request->get('per_page', 15);
        $logs = $this->adminService->getUserTransactionLogs($user, $perPage);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'account_number' => $user->account_number,
                'name' => $user->name,
            ],
            'logs' => $logs->items(),
            'pagination' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'total' => $logs->total(),
            ],
        ]);
    }

    public function transactions(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $transactions = $this->adminService->getAllTransactions($perPage);

        $formattedTransactions = collect($transactions->items())->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'reference_number' => $transaction->reference_number,
                'user' => [
                    'id' => $transaction->user->id,
                    'account_number' => $transaction->user->account_number,
                    'name' => $transaction->user->name,
                ],
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'description' => $transaction->description,
                'created_at' => $transaction->created_at,
            ];
        });

        return response()->json([
            'transactions' => $formattedTransactions,
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }

    public function failedWithdrawals(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $logs = $this->adminService->getFailedWithdrawals($perPage);

        $formattedLogs = collect($logs->items())->map(function ($log) {
            return [
                'id' => $log->id,
                'user' => [
                    'id' => $log->user->id,
                    'account_number' => $log->user->account_number,
                    'name' => $log->user->name,
                ],
                'amount' => $log->amount,
                'failure_reason' => $log->failure_reason,
                'ip_address' => $log->ip_address,
                'created_at' => $log->created_at,
            ];
        });

        return response()->json([
            'failed_withdrawals' => $formattedLogs,
            'pagination' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'total' => $logs->total(),
            ],
        ]);
    }

    public function dailySummary(Request $request)
    {
        $date = $request->get('date')
            ? Carbon::parse($request->get('date'))
            : Carbon::today();

        $summary = $this->adminService->getDailySummary($date);

        return response()->json([
            'summary' => $summary,
        ]);
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Cannot modify admin status',
            ], 403);
        }

        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'message' => $user->is_active ? 'User activated' : 'User deactivated',
            'user' => [
                'id' => $user->id,
                'is_active' => $user->is_active,
            ],
        ]);
    }
}
