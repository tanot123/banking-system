<template>
    <div>
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
            <router-link to="/admin/users" class="text-blue-600 hover:text-blue-900">&larr; Back to Users</router-link>
        </div>

        <div v-if="adminStore.loading" class="text-center text-gray-500 py-8">Loading...</div>

        <div v-else-if="adminStore.selectedUser" class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Account Number</div>
                        <div class="font-mono font-medium">{{ adminStore.selectedUser.account_number }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Name</div>
                        <div class="font-medium">{{ adminStore.selectedUser.name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Email</div>
                        <div class="font-medium">{{ adminStore.selectedUser.email }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Balance</div>
                        <div class="text-xl font-bold text-green-600">₱{{ formatCurrency(adminStore.selectedUser.balance) }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Transactions</h2>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="tx in adminStore.selectedUserTransactions" :key="tx.id">
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ formatDate(tx.created_at) }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="tx.type === 'deposit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                        {{ tx.type }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-right font-medium" :class="tx.type === 'deposit' ? 'text-green-600' : 'text-red-600'">
                                    {{ tx.type === 'deposit' ? '+' : '-' }}₱{{ formatCurrency(tx.amount) }}
                                </td>
                            </tr>
                            <tr v-if="adminStore.selectedUserTransactions.length === 0">
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No transactions</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Activity Logs</h2>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="log in adminStore.selectedUserLogs" :key="log.id">
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ formatDate(log.created_at) }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ log.type }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="log.status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                        {{ log.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-right font-medium">₱{{ formatCurrency(log.amount) }}</td>
                            </tr>
                            <tr v-if="adminStore.selectedUserLogs.length === 0">
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No logs</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useAdminStore } from '../../stores/admin';

const route = useRoute();
const adminStore = useAdminStore();

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
};

const formatDate = (date) => {
    return new Date(date).toLocaleString('en-PH', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

onMounted(() => {
    const userId = route.params.id;
    adminStore.fetchUser(userId);
    adminStore.fetchUserTransactions(userId);
    adminStore.fetchUserLogs(userId);
});
</script>
