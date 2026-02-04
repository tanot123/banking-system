<template>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Daily Summary Report</h1>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-center space-x-4">
                <label for="date" class="text-sm font-medium text-gray-700">Select Date:</label>
                <input
                    type="date"
                    id="date"
                    v-model="selectedDate"
                    @change="fetchSummary"
                    class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                />
            </div>
        </div>

        <div v-if="adminStore.loading" class="text-center text-gray-500 py-8">Loading...</div>

        <div v-else-if="adminStore.dailySummary" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm font-medium text-gray-500">Total Deposits</div>
                    <div class="mt-2 text-2xl font-bold text-green-600">₱{{ formatCurrency(adminStore.dailySummary.total_deposits) }}</div>
                    <div class="text-sm text-gray-400">{{ adminStore.dailySummary.deposit_count }} transactions</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm font-medium text-gray-500">Total Withdrawals</div>
                    <div class="mt-2 text-2xl font-bold text-red-600">₱{{ formatCurrency(adminStore.dailySummary.total_withdrawals) }}</div>
                    <div class="text-sm text-gray-400">{{ adminStore.dailySummary.withdrawal_count }} transactions</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm font-medium text-gray-500">Failed Withdrawals</div>
                    <div class="mt-2 text-2xl font-bold text-orange-600">{{ adminStore.dailySummary.failed_withdrawals }}</div>
                    <div class="text-sm text-gray-400">attempts</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm font-medium text-gray-500">Net Flow</div>
                    <div class="mt-2 text-2xl font-bold" :class="adminStore.dailySummary.net_flow >= 0 ? 'text-green-600' : 'text-red-600'">
                        {{ adminStore.dailySummary.net_flow >= 0 ? '+' : '' }}₱{{ formatCurrency(adminStore.dailySummary.net_flow) }}
                    </div>
                    <div class="text-sm text-gray-400">deposits - withdrawals</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Summary for {{ formatDisplayDate(adminStore.dailySummary.date) }}</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="border-l-4 border-green-500 pl-4">
                        <div class="text-sm text-gray-500">Deposits</div>
                        <div class="text-xl font-semibold">{{ adminStore.dailySummary.deposit_count }} transactions</div>
                        <div class="text-lg text-green-600">₱{{ formatCurrency(adminStore.dailySummary.total_deposits) }}</div>
                    </div>
                    <div class="border-l-4 border-red-500 pl-4">
                        <div class="text-sm text-gray-500">Withdrawals</div>
                        <div class="text-xl font-semibold">{{ adminStore.dailySummary.withdrawal_count }} transactions</div>
                        <div class="text-lg text-red-600">₱{{ formatCurrency(adminStore.dailySummary.total_withdrawals) }}</div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="text-sm text-gray-500">Active Users</div>
                    <div class="text-xl font-semibold">{{ adminStore.dailySummary.active_users }} users made transactions</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAdminStore } from '../../stores/admin';

const adminStore = useAdminStore();
const selectedDate = ref(new Date().toISOString().split('T')[0]);

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
};

const formatDisplayDate = (date) => {
    return new Date(date).toLocaleDateString('en-PH', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const fetchSummary = () => {
    adminStore.fetchDailySummary(selectedDate.value);
};

onMounted(() => {
    fetchSummary();
});
</script>
