<template>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>

        <div v-if="adminStore.loading" class="text-center text-gray-500 py-8">Loading...</div>

        <div v-else-if="adminStore.dashboard" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm font-medium text-gray-500">Total Users</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ adminStore.dashboard.total_users }}</div>
                    <div class="text-sm text-gray-500">{{ adminStore.dashboard.active_users }} active</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm font-medium text-gray-500">System Balance</div>
                    <div class="mt-2 text-3xl font-bold text-green-600">₱{{ formatCurrency(adminStore.dashboard.system_balance) }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm font-medium text-gray-500">Total Deposits</div>
                    <div class="mt-2 text-3xl font-bold text-blue-600">₱{{ formatCurrency(adminStore.dashboard.total_deposits) }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm font-medium text-gray-500">Total Withdrawals</div>
                    <div class="mt-2 text-3xl font-bold text-red-600">₱{{ formatCurrency(adminStore.dashboard.total_withdrawals) }}</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Today's Summary</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Deposits</div>
                        <div class="text-xl font-semibold text-green-600">₱{{ formatCurrency(adminStore.dashboard.today.total_deposits) }}</div>
                        <div class="text-sm text-gray-400">{{ adminStore.dashboard.today.deposit_count }} transactions</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Withdrawals</div>
                        <div class="text-xl font-semibold text-red-600">₱{{ formatCurrency(adminStore.dashboard.today.total_withdrawals) }}</div>
                        <div class="text-sm text-gray-400">{{ adminStore.dashboard.today.withdrawal_count }} transactions</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Failed Withdrawals</div>
                        <div class="text-xl font-semibold text-orange-600">{{ adminStore.dashboard.today.failed_withdrawals }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Net Flow</div>
                        <div class="text-xl font-semibold" :class="adminStore.dashboard.today.net_flow >= 0 ? 'text-green-600' : 'text-red-600'">
                            {{ adminStore.dashboard.today.net_flow >= 0 ? '+' : '' }}₱{{ formatCurrency(adminStore.dashboard.today.net_flow) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <router-link to="/admin/users" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900">User Management</h3>
                    <p class="text-sm text-gray-500 mt-1">View and manage user accounts</p>
                </router-link>
                <router-link to="/admin/transactions" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900">Transaction History</h3>
                    <p class="text-sm text-gray-500 mt-1">View all system transactions</p>
                </router-link>
                <router-link to="/admin/failed-withdrawals" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900">Failed Withdrawals</h3>
                    <p class="text-sm text-gray-500 mt-1">View failed withdrawal attempts</p>
                </router-link>
                <router-link to="/admin/daily-summary" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900">Daily Summary</h3>
                    <p class="text-sm text-gray-500 mt-1">View daily transaction reports</p>
                </router-link>
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

onMounted(() => {
    adminStore.fetchDashboard();
});
</script>
