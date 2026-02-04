<template>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Failed Withdrawal Attempts</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div v-if="adminStore.loading" class="p-6 text-center text-gray-500">Loading...</div>
            <table v-else class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="log in adminStore.failedWithdrawals" :key="log.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ formatDate(log.created_at) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <router-link :to="`/admin/users/${log.user.id}`" class="text-blue-600 hover:text-blue-900">
                                {{ log.user.name }}
                            </router-link>
                            <div class="text-xs text-gray-500">{{ log.user.account_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-red-600">
                            ₱{{ formatCurrency(log.amount) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ log.failure_reason }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500">
                            {{ log.ip_address }}
                        </td>
                    </tr>
                    <tr v-if="adminStore.failedWithdrawals.length === 0">
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No failed withdrawals found</td>
                    </tr>
                </tbody>
            </table>

            <div v-if="adminStore.failedWithdrawalsPagination && adminStore.failedWithdrawalsPagination.last_page > 1" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Page <span class="font-medium">{{ adminStore.failedWithdrawalsPagination.current_page }}</span> of <span class="font-medium">{{ adminStore.failedWithdrawalsPagination.last_page }}</span>
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            <button @click="changePage(adminStore.failedWithdrawalsPagination.current_page - 1)" :disabled="adminStore.failedWithdrawalsPagination.current_page === 1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                                Previous
                            </button>
                            <button @click="changePage(adminStore.failedWithdrawalsPagination.current_page + 1)" :disabled="adminStore.failedWithdrawalsPagination.current_page === adminStore.failedWithdrawalsPagination.last_page" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                                Next
                            </button>
                        </nav>
                    </div>
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
    return new Date(date).toLocaleString('en-PH', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const changePage = (page) => {
    adminStore.fetchFailedWithdrawals(page);
};

onMounted(() => {
    adminStore.fetchFailedWithdrawals();
});
</script>
