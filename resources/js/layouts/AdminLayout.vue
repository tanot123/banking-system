<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-semibold text-white">ATM Admin</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <router-link
                            to="/admin/dashboard"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/admin/dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white'"
                        >
                            Dashboard
                        </router-link>
                        <router-link
                            to="/admin/users"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/admin/users') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white'"
                        >
                            Users
                        </router-link>
                        <router-link
                            to="/admin/transactions"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/admin/transactions') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white'"
                        >
                            Transactions
                        </router-link>
                        <router-link
                            to="/admin/failed-withdrawals"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/admin/failed-withdrawals') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white'"
                        >
                            Failed Withdrawals
                        </router-link>
                        <router-link
                            to="/admin/daily-summary"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/admin/daily-summary') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white'"
                        >
                            Daily Summary
                        </router-link>
                        <div class="border-l border-gray-600 pl-4 ml-4">
                            <span class="text-sm text-gray-300">{{ authStore.user?.name }}</span>
                            <button
                                @click="handleLogout"
                                class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-red-400 hover:text-red-300"
                            >
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <router-view />
        </main>
    </div>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();

const isActive = (path) => route.path.startsWith(path);

const handleLogout = async () => {
    await authStore.logout();
    router.push('/login');
};
</script>
