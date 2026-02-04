import api from './api';

export const adminService = {
    async getDashboard() {
        const response = await api.get('/admin/dashboard');
        return response.data;
    },

    async getUsers(page = 1, perPage = 15) {
        const response = await api.get('/admin/users', {
            params: { page, per_page: perPage },
        });
        return response.data;
    },

    async getUser(id) {
        const response = await api.get(`/admin/users/${id}`);
        return response.data;
    },

    async getUserTransactions(id, page = 1, perPage = 15) {
        const response = await api.get(`/admin/users/${id}/transactions`, {
            params: { page, per_page: perPage },
        });
        return response.data;
    },

    async getUserLogs(id, page = 1, perPage = 15) {
        const response = await api.get(`/admin/users/${id}/logs`, {
            params: { page, per_page: perPage },
        });
        return response.data;
    },

    async toggleUserStatus(id) {
        const response = await api.patch(`/admin/users/${id}/toggle-status`);
        return response.data;
    },

    async getTransactions(page = 1, perPage = 15) {
        const response = await api.get('/admin/transactions', {
            params: { page, per_page: perPage },
        });
        return response.data;
    },

    async getFailedWithdrawals(page = 1, perPage = 15) {
        const response = await api.get('/admin/failed-withdrawals', {
            params: { page, per_page: perPage },
        });
        return response.data;
    },

    async getDailySummary(date = null) {
        const response = await api.get('/admin/daily-summary', {
            params: date ? { date } : {},
        });
        return response.data;
    },
};
