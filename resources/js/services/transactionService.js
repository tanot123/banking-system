import api from './api';

export const transactionService = {
    async getBalance() {
        const response = await api.get('/transactions/balance');
        return response.data;
    },

    async deposit(data) {
        const response = await api.post('/transactions/deposit', data);
        return response.data;
    },

    async withdraw(data) {
        const response = await api.post('/transactions/withdraw', data);
        return response.data;
    },

    async getHistory(page = 1, perPage = 15) {
        const response = await api.get('/transactions/history', {
            params: { page, per_page: perPage },
        });
        return response.data;
    },
};
