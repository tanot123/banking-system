import { defineStore } from 'pinia';
import { adminService } from '../services/adminService';

export const useAdminStore = defineStore('admin', {
    state: () => ({
        dashboard: null,
        users: [],
        usersPagination: null,
        transactions: [],
        transactionsPagination: null,
        failedWithdrawals: [],
        failedWithdrawalsPagination: null,
        dailySummary: null,
        selectedUser: null,
        selectedUserTransactions: [],
        selectedUserLogs: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchDashboard() {
            this.loading = true;
            try {
                const data = await adminService.getDashboard();
                this.dashboard = data.stats;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch dashboard';
            } finally {
                this.loading = false;
            }
        },

        async fetchUsers(page = 1) {
            this.loading = true;
            try {
                const data = await adminService.getUsers(page);
                this.users = data.users;
                this.usersPagination = data.pagination;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch users';
            } finally {
                this.loading = false;
            }
        },

        async fetchUser(id) {
            this.loading = true;
            try {
                const data = await adminService.getUser(id);
                this.selectedUser = data.user;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch user';
            } finally {
                this.loading = false;
            }
        },

        async fetchUserTransactions(id, page = 1) {
            this.loading = true;
            try {
                const data = await adminService.getUserTransactions(id, page);
                this.selectedUserTransactions = data.transactions;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch user transactions';
            } finally {
                this.loading = false;
            }
        },

        async fetchUserLogs(id, page = 1) {
            this.loading = true;
            try {
                const data = await adminService.getUserLogs(id, page);
                this.selectedUserLogs = data.logs;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch user logs';
            } finally {
                this.loading = false;
            }
        },

        async toggleUserStatus(id) {
            this.loading = true;
            try {
                const data = await adminService.toggleUserStatus(id);
                const index = this.users.findIndex(u => u.id === id);
                if (index !== -1) {
                    this.users[index].is_active = data.user.is_active;
                }
                return data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to toggle user status';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchTransactions(page = 1) {
            this.loading = true;
            try {
                const data = await adminService.getTransactions(page);
                this.transactions = data.transactions;
                this.transactionsPagination = data.pagination;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch transactions';
            } finally {
                this.loading = false;
            }
        },

        async fetchFailedWithdrawals(page = 1) {
            this.loading = true;
            try {
                const data = await adminService.getFailedWithdrawals(page);
                this.failedWithdrawals = data.failed_withdrawals;
                this.failedWithdrawalsPagination = data.pagination;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch failed withdrawals';
            } finally {
                this.loading = false;
            }
        },

        async fetchDailySummary(date = null) {
            this.loading = true;
            try {
                const data = await adminService.getDailySummary(date);
                this.dailySummary = data.summary;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch daily summary';
            } finally {
                this.loading = false;
            }
        },
    },
});
