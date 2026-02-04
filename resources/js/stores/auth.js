import { defineStore } from 'pinia';
import { authService } from '../services/authService';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user')) || null,
        token: localStorage.getItem('token') || null,
        loading: false,
        error: null,
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
        isAdmin: (state) => state.user?.role === 'admin',
        isUser: (state) => state.user?.role === 'user',
    },

    actions: {
        async login(credentials) {
            this.loading = true;
            this.error = null;
            try {
                const data = await authService.login(credentials);
                this.token = data.token;
                this.user = data.user;
                localStorage.setItem('token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));
                return data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Login failed';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async register(data) {
            this.loading = true;
            this.error = null;
            try {
                const response = await authService.register(data);
                this.token = response.token;
                this.user = response.user;
                localStorage.setItem('token', response.token);
                localStorage.setItem('user', JSON.stringify(response.user));
                return response;
            } catch (error) {
                this.error = error.response?.data?.message || 'Registration failed';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            try {
                await authService.logout();
            } catch (error) {
            } finally {
                this.token = null;
                this.user = null;
                localStorage.removeItem('token');
                localStorage.removeItem('user');
            }
        },

        async fetchUser() {
            if (!this.token) return;
            try {
                const data = await authService.me();
                this.user = data.user;
                localStorage.setItem('user', JSON.stringify(data.user));
            } catch (error) {
                this.logout();
            }
        },
    },
});
