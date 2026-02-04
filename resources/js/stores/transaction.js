import { defineStore } from 'pinia';
import { transactionService } from '../services/transactionService';

export const useTransactionStore = defineStore('transaction', {
    state: () => ({
        balance: 0,
        accountNumber: '',
        todayWithdrawalCount: 0,
        todayWithdrawalAmount: 0,
        remainingDailyWithdrawals: 3,
        remainingDailyAmount: 5000,
        transactions: [],
        pagination: null,
        loading: false,
        error: null,
    }),

    actions: {
        async fetchBalance() {
            this.loading = true;
            try {
                const data = await transactionService.getBalance();
                this.balance = data.balance;
                this.accountNumber = data.account_number;
                this.todayWithdrawalCount = data.today_withdrawal_count;
                this.todayWithdrawalAmount = data.today_withdrawal_amount;
                this.remainingDailyWithdrawals = data.remaining_daily_withdrawals;
                this.remainingDailyAmount = data.remaining_daily_amount;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch balance';
            } finally {
                this.loading = false;
            }
        },

        async deposit(amount, description = '') {
            this.loading = true;
            this.error = null;
            try {
                const data = await transactionService.deposit({ amount, description });
                this.balance = data.new_balance;
                return data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Deposit failed';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async withdraw(amount, description = '') {
            this.loading = true;
            this.error = null;
            try {
                const data = await transactionService.withdraw({ amount, description });
                this.balance = data.new_balance;
                await this.fetchBalance();
                return data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Withdrawal failed';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchHistory(page = 1) {
            this.loading = true;
            try {
                const data = await transactionService.getHistory(page);
                this.transactions = data.transactions;
                this.pagination = data.pagination;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch history';
            } finally {
                this.loading = false;
            }
        },
    },
});
