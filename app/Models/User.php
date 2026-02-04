<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'account_number',
        'name',
        'email',
        'password',
        'pin',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'pin',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'pin' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function transactionLogs(): HasMany
    {
        return $this->hasMany(TransactionLog::class);
    }

    public function getBalanceAttribute(): float
    {
        $deposits = $this->transactions()->where('type', 'deposit')->sum('amount');
        $withdrawals = $this->transactions()->where('type', 'withdrawal')->sum('amount');
        return (float) ($deposits - $withdrawals);
    }

    public function getTodayWithdrawalCountAttribute(): int
    {
        return $this->transactions()
            ->where('type', 'withdrawal')
            ->whereDate('created_at', today())
            ->count();
    }

    public function getTodayWithdrawalAmountAttribute(): float
    {
        return (float) $this->transactions()
            ->where('type', 'withdrawal')
            ->whereDate('created_at', today())
            ->sum('amount');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public static function generateAccountNumber(): string
    {
        do {
            $number = 'ATM' . str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (self::where('account_number', $number)->exists());

        return $number;
    }
}
