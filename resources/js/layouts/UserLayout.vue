<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100">
        <div class="flex h-screen overflow-hidden">
            <div
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-emerald-800 via-emerald-900 to-emerald-950 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
            >
                <div class="flex flex-col h-full">
                    <div class="flex items-center justify-between h-16 px-6 border-b border-emerald-700/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xl font-bold text-white">ATM Banking</span>
                            </div>
                        </div>
                        <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-lg text-emerald-300 hover:bg-emerald-700/50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                        <div class="mb-4">
                            <p class="px-3 text-xs font-semibold text-emerald-400 uppercase tracking-wider">Main Menu</p>
                        </div>

                        <router-link
                            to="/user/dashboard"
                            @click="sidebarOpen = false"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200"
                            :class="isActive('/user/dashboard') ? 'bg-emerald-600/50 text-white shadow-lg shadow-emerald-900/30' : 'text-emerald-100 hover:bg-emerald-700/40 hover:text-white'"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Dashboard</span>
                        </router-link>

                        <div class="pt-4 mb-4">
                            <p class="px-3 text-xs font-semibold text-emerald-400 uppercase tracking-wider">Transactions</p>
                        </div>

                        <router-link
                            to="/user/deposit"
                            @click="sidebarOpen = false"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200"
                            :class="isActive('/user/deposit') ? 'bg-emerald-600/50 text-white shadow-lg shadow-emerald-900/30' : 'text-emerald-100 hover:bg-emerald-700/40 hover:text-white'"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Deposit Money</span>
                        </router-link>

                        <router-link
                            to="/user/withdraw"
                            @click="sidebarOpen = false"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200"
                            :class="isActive('/user/withdraw') ? 'bg-emerald-600/50 text-white shadow-lg shadow-emerald-900/30' : 'text-emerald-100 hover:bg-emerald-700/40 hover:text-white'"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            <span>Withdraw Money</span>
                        </router-link>

                        <div class="pt-4 mb-4">
                            <p class="px-3 text-xs font-semibold text-emerald-400 uppercase tracking-wider">Account</p>
                        </div>

                        <router-link
                            to="/user/history"
                            @click="sidebarOpen = false"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200"
                            :class="isActive('/user/history') ? 'bg-emerald-600/50 text-white shadow-lg shadow-emerald-900/30' : 'text-emerald-100 hover:bg-emerald-700/40 hover:text-white'"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Transaction History</span>
                        </router-link>
                    </div>

                    <div class="p-4 border-t border-emerald-700/50">
                        <div class="flex items-center space-x-3 px-3 py-3 rounded-xl bg-emerald-800/50">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                                {{ authStore.user?.name?.charAt(0)?.toUpperCase() }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-white truncate">{{ authStore.user?.name }}</p>
                                <p class="text-xs text-emerald-300 truncate">{{ authStore.user?.account_number }}</p>
                            </div>
                            <button
                                @click="handleLogout"
                                class="p-2 rounded-lg text-emerald-300 hover:bg-emerald-700/50 hover:text-white transition-all duration-200"
                                title="Logout"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"></div>

            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/50 sticky top-0 z-30">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <div class="hidden lg:block">
                                <h1 class="text-lg font-semibold text-gray-900">{{ pageTitle }}</h1>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="hidden sm:flex items-center space-x-3 px-4 py-2 bg-emerald-50 rounded-xl">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-emerald-700">Online</span>
                            </div>
                            <div class="lg:hidden flex items-center space-x-3">
                                <div class="w-9 h-9 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                    {{ authStore.user?.name?.charAt(0)?.toUpperCase() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    <router-view />
                </main>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const sidebarOpen = ref(false);

const isActive = (path) => route.path === path;

const pageTitle = computed(() => {
    const titles = {
        '/user/dashboard': 'Account Dashboard',
        '/user/deposit': 'Deposit Money',
        '/user/withdraw': 'Withdraw Money',
        '/user/history': 'Transaction History',
    };
    return titles[route.path] || 'ATM Banking';
});

const handleLogout = async () => {
    await authStore.logout();
    router.push('/login');
};
</script>
