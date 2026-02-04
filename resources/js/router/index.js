import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

import AuthLayout from '../layouts/AuthLayout.vue';
import UserLayout from '../layouts/UserLayout.vue';
import AdminLayout from '../layouts/AdminLayout.vue';

import Login from '../views/auth/Login.vue';
import Register from '../views/auth/Register.vue';

import UserDashboard from '../views/user/Dashboard.vue';
import UserDeposit from '../views/user/Deposit.vue';
import UserWithdraw from '../views/user/Withdraw.vue';
import UserHistory from '../views/user/History.vue';

import AdminDashboard from '../views/admin/Dashboard.vue';
import AdminUsers from '../views/admin/Users.vue';
import AdminUserDetail from '../views/admin/UserDetail.vue';
import AdminTransactions from '../views/admin/Transactions.vue';
import AdminFailedWithdrawals from '../views/admin/FailedWithdrawals.vue';
import AdminDailySummary from '../views/admin/DailySummary.vue';

const routes = [
    {
        path: '/',
        redirect: '/login',
    },
    {
        path: '/',
        component: AuthLayout,
        children: [
            {
                path: 'login',
                name: 'login',
                component: Login,
                meta: { guest: true },
            },
            {
                path: 'register',
                name: 'register',
                component: Register,
                meta: { guest: true },
            },
        ],
    },
    {
        path: '/user',
        component: UserLayout,
        meta: { requiresAuth: true, role: 'user' },
        children: [
            {
                path: '',
                redirect: '/user/dashboard',
            },
            {
                path: 'dashboard',
                name: 'user.dashboard',
                component: UserDashboard,
            },
            {
                path: 'deposit',
                name: 'user.deposit',
                component: UserDeposit,
            },
            {
                path: 'withdraw',
                name: 'user.withdraw',
                component: UserWithdraw,
            },
            {
                path: 'history',
                name: 'user.history',
                component: UserHistory,
            },
        ],
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true, role: 'admin' },
        children: [
            {
                path: '',
                redirect: '/admin/dashboard',
            },
            {
                path: 'dashboard',
                name: 'admin.dashboard',
                component: AdminDashboard,
            },
            {
                path: 'users',
                name: 'admin.users',
                component: AdminUsers,
            },
            {
                path: 'users/:id',
                name: 'admin.user.detail',
                component: AdminUserDetail,
            },
            {
                path: 'transactions',
                name: 'admin.transactions',
                component: AdminTransactions,
            },
            {
                path: 'failed-withdrawals',
                name: 'admin.failed-withdrawals',
                component: AdminFailedWithdrawals,
            },
            {
                path: 'daily-summary',
                name: 'admin.daily-summary',
                component: AdminDailySummary,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({ name: 'login' });
        return;
    }

    if (to.meta.guest && authStore.isAuthenticated) {
        if (authStore.isAdmin) {
            next({ name: 'admin.dashboard' });
        } else {
            next({ name: 'user.dashboard' });
        }
        return;
    }

    if (to.meta.role === 'admin' && !authStore.isAdmin) {
        next({ name: 'user.dashboard' });
        return;
    }

    if (to.meta.role === 'user' && authStore.isAdmin) {
        next({ name: 'admin.dashboard' });
        return;
    }

    next();
});

export default router;
