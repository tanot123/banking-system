<template>
    <div class="min-h-screen">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
            <p class="mt-2 text-gray-600">Welcome back! Here's what's happening with your banking system.</p>
        </div>

        <div v-if="adminStore.loading" class="flex items-center justify-center py-16">
            <div class="flex flex-col items-center space-y-4">
                <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-gray-500 font-medium">Loading dashboard...</p>
            </div>
        </div>

        <div v-else-if="adminStore.dashboard" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="relative overflow-hidden bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-16 h-16 bg-white/10 rounded-full"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-indigo-100 text-sm font-medium uppercase tracking-wide">Total Users</p>
                                <p class="mt-2 text-4xl font-bold">{{ adminStore.dashboard.total_users }}</p>
                            </div>
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            <span class="bg-white/20 px-2 py-1 rounded-full text-xs font-medium">{{ adminStore.dashboard.active_users }} active</span>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-16 h-16 bg-white/10 rounded-full"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-emerald-100 text-sm font-medium uppercase tracking-wide">System Balance</p>
                                <p class="mt-2 text-4xl font-bold">₱{{ formatCurrency(adminStore.dashboard.system_balance) }}</p>
                            </div>
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            <span class="text-emerald-100">Total funds in system</span>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-16 h-16 bg-white/10 rounded-full"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Deposits</p>
                                <p class="mt-2 text-4xl font-bold">₱{{ formatCurrency(adminStore.dashboard.total_deposits) }}</p>
                            </div>
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-blue-100">All time deposits</span>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-16 h-16 bg-white/10 rounded-full"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-rose-100 text-sm font-medium uppercase tracking-wide">Total Withdrawals</p>
                                <p class="mt-2 text-4xl font-bold">₱{{ formatCurrency(adminStore.dashboard.total_withdrawals) }}</p>
                            </div>
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-rose-100">All time withdrawals</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Today's Summary</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ formatDate(new Date()) }}</p>
                        </div>
                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            Live
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-100">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 bg-green-500 rounded-lg p-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-800">Deposits</p>
                                </div>
                            </div>
                            <p class="mt-4 text-2xl font-bold text-green-700">₱{{ formatCurrency(adminStore.dashboard.today.total_deposits) }}</p>
                            <p class="mt-1 text-sm text-green-600">{{ adminStore.dashboard.today.deposit_count }} transactions</p>
                        </div>

                        <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-xl p-5 border border-red-100">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 bg-red-500 rounded-lg p-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-red-800">Withdrawals</p>
                                </div>
                            </div>
                            <p class="mt-4 text-2xl font-bold text-red-700">₱{{ formatCurrency(adminStore.dashboard.today.total_withdrawals) }}</p>
                            <p class="mt-1 text-sm text-red-600">{{ adminStore.dashboard.today.withdrawal_count }} transactions</p>
                        </div>

                        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-5 border border-orange-100">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 bg-orange-500 rounded-lg p-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-orange-800">Failed Withdrawals</p>
                                </div>
                            </div>
                            <p class="mt-4 text-2xl font-bold text-orange-700">{{ adminStore.dashboard.today.failed_withdrawals }}</p>
                            <p class="mt-1 text-sm text-orange-600">attempts today</p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 rounded-lg p-2" :class="adminStore.dashboard.today.net_flow >= 0 ? 'bg-blue-500' : 'bg-purple-500'">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Net Flow</p>
                                </div>
                            </div>
                            <p class="mt-4 text-2xl font-bold" :class="adminStore.dashboard.today.net_flow >= 0 ? 'text-blue-700' : 'text-purple-700'">
                                {{ adminStore.dashboard.today.net_flow >= 0 ? '+' : '' }}₱{{ formatCurrency(adminStore.dashboard.today.net_flow) }}
                            </p>
                            <p class="mt-1 text-sm" :class="adminStore.dashboard.today.net_flow >= 0 ? 'text-blue-600' : 'text-purple-600'">
                                {{ adminStore.dashboard.today.net_flow >= 0 ? 'positive flow' : 'negative flow' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <router-link to="/admin/users" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="p-6">
                            <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-colors duration-300">
                                <svg class="w-7 h-7 text-indigo-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">User Management</h3>
                            <p class="text-sm text-gray-500 mt-2">View and manage user accounts</p>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 group-hover:bg-indigo-50 transition-colors">
                            <span class="text-sm font-medium text-indigo-600 flex items-center">
                                View all users
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </router-link>

                    <router-link to="/admin/transactions" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="p-6">
                            <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-emerald-500 transition-colors duration-300">
                                <svg class="w-7 h-7 text-emerald-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">Transaction History</h3>
                            <p class="text-sm text-gray-500 mt-2">View all system transactions</p>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 group-hover:bg-emerald-50 transition-colors">
                            <span class="text-sm font-medium text-emerald-600 flex items-center">
                                View transactions
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </router-link>

                    <router-link to="/admin/failed-withdrawals" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="p-6">
                            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-orange-500 transition-colors duration-300">
                                <svg class="w-7 h-7 text-orange-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-orange-600 transition-colors">Failed Withdrawals</h3>
                            <p class="text-sm text-gray-500 mt-2">View failed withdrawal attempts</p>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 group-hover:bg-orange-50 transition-colors">
                            <span class="text-sm font-medium text-orange-600 flex items-center">
                                View failed attempts
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </router-link>

                    <router-link to="/admin/daily-summary" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="p-6">
                            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-500 transition-colors duration-300">
                                <svg class="w-7 h-7 text-purple-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">Daily Summary</h3>
                            <p class="text-sm text-gray-500 mt-2">View daily transaction reports</p>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 group-hover:bg-purple-50 transition-colors">
                            <span class="text-sm font-medium text-purple-600 flex items-center">
                                View reports
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAdminStore } from '../../stores/admin';

const adminStore = useAdminStore();

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
};

const formatDate = (date) => {
    return new Intl.DateTimeFormat('en-PH', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }).format(date);
};

onMounted(() => {
    adminStore.fetchDashboard();
});
</script>
