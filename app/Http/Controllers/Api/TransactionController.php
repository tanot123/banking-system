<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    ) {}

    public function balance(Request $request)
    {
        $user = $request->user();
        $maxWithdrawals = config('banking.max_daily_withdrawals', 3);
        $maxAmount = config('banking.max_daily_withdrawal_amount', 5000);

        return response()->json([
            'balance' => $user->balance,
            'account_number' => $user->account_number,
            'today_withdrawal_count' => $user->today_withdrawal_count,
            'today_withdrawal_amount' => $user->today_withdrawal_amount,
            'remaining_daily_withdrawals' => max(0, $maxWithdrawals - $user->today_withdrawal_count),
            'remaining_daily_amount' => max(0, $maxAmount - $user->today_withdrawal_amount),
        ]);
    }

    public function deposit(DepositRequest $request)
    {
        $validated = $request->validated();

        $result = $this->transactionService->deposit(
            $request->user(),
            $validated['amount'],
            $validated['description'] ?? null,
            $request->ip()
        );

        return response()->json([
            'message' => 'Deposit successful',
            'transaction' => [
                'reference_number' => $result['transaction']->reference_number,
                'amount' => $result['transaction']->amount,
                'type' => $result['transaction']->type,
                'created_at' => $result['transaction']->created_at,
            ],
            'new_balance' => $result['new_balance'],
        ]);
    }

    public function withdraw(WithdrawRequest $request)
    {
        $validated = $request->validated();

        $result = $this->transactionService->withdraw(
            $request->user(),
            $validated['amount'],
            $validated['description'] ?? null,
            $request->ip()
        );

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'message' => 'Withdrawal successful',
            'transaction' => [
                'reference_number' => $result['transaction']->reference_number,
                'amount' => $result['transaction']->amount,
                'type' => $result['transaction']->type,
                'created_at' => $result['transaction']->created_at,
            ],
            'new_balance' => $result['new_balance'],
        ]);
    }

    public function history(Request $request)
    {
        $perPage = $request->get('per_page', 15);

        $transactions = $this->transactionService->getTransactionHistory(
            $request->user(),
            $perPage
        );

        return response()->json([
            'transactions' => $transactions->items(),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }
}
