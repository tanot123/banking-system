<?php

return [
    'max_daily_withdrawals' => env('MAX_DAILY_WITHDRAWALS', 3),
    'max_daily_withdrawal_amount' => env('MAX_DAILY_WITHDRAWAL_AMOUNT', 5000),
    'min_deposit_amount' => env('MIN_DEPOSIT_AMOUNT', 1),
    'min_withdrawal_amount' => env('MIN_WITHDRAWAL_AMOUNT', 1),
];
