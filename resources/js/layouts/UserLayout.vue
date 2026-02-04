<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-semibold text-gray-900">ATM Banking</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <router-link
                            to="/user/dashboard"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/user/dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900'"
                        >
                            Dashboard
                        </router-link>
                        <router-link
                            to="/user/deposit"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/user/deposit') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900'"
                        >
                            Deposit
                        </router-link>
                        <router-link
                            to="/user/withdraw"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/user/withdraw') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900'"
                        >
                            Withdraw
                        </router-link>
                        <router-link
                            to="/user/history"
                            class="px-3 py-2 rounded-md text-sm font-medium"
                            :class="isActive('/user/history') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900'"
                        >
                            History
                        </router-link>
                        <div class="border-l pl-4 ml-4">
                            <span class="text-sm text-gray-500">{{ authStore.user?.name }}</span>
                            <button
                                @click="handleLogout"
                                class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:text-red-700"
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

const isActive = (path) => route.path === path;

const handleLogout = async () => {
    await authStore.logout();
    router.push('/login');
};
</script>
