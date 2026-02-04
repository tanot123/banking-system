<template>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Transaction History</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div v-if="transactionStore.loading" class="p-6 text-center text-gray-500">
                Loading...
            </div>
            <table v-else class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="transaction in transactionStore.transactions" :key="transaction.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ formatDate(transaction.created_at) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                            {{ transaction.reference_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                :class="transaction.type === 'deposit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                            >
                                {{ transaction.type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ transaction.description || '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium" :class="transaction.type === 'deposit' ? 'text-green-600' : 'text-red-600'">
                            {{ transaction.type === 'deposit' ? '+' : '-' }}₱{{ formatCurrency(transaction.amount) }}
                        </td>
                    </tr>
                    <tr v-if="transactionStore.transactions.length === 0">
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No transactions found</td>
                    </tr>
                </tbody>
            </table>

            <div v-if="transactionStore.pagination && transactionStore.pagination.last_page > 1" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button @click="changePage(transactionStore.pagination.current_page - 1)" :disabled="transactionStore.pagination.current_page === 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                        Previous
                    </button>
                    <button @click="changePage(transactionStore.pagination.current_page + 1)" :disabled="transactionStore.pagination.current_page === transactionStore.pagination.last_page" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                        Next
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Page <span class="font-medium">{{ transactionStore.pagination.current_page }}</span> of <span class="font-medium">{{ transactionStore.pagination.last_page }}</span>
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            <button @click="changePage(transactionStore.pagination.current_page - 1)" :disabled="transactionStore.pagination.current_page === 1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                                Previous
                            </button>
                            <button @click="changePage(transactionStore.pagination.current_page + 1)" :disabled="transactionStore.pagination.current_page === transactionStore.pagination.last_page" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
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
import { useTransactionStore } from '../../stores/transaction';

const transactionStore = useTransactionStore();

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
    transactionStore.fetchHistory(page);
};

onMounted(() => {
    transactionStore.fetchHistory();
});
</script>
