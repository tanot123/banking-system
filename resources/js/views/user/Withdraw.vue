<template>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Withdraw</h1>

        <div class="bg-white rounded-lg shadow p-6 max-w-lg">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <div class="text-sm text-gray-500">Current Balance</div>
                    <div class="text-2xl font-bold text-green-600">₱{{ formatCurrency(transactionStore.balance) }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Remaining Daily Limit</div>
                    <div class="text-lg font-semibold text-gray-900">₱{{ formatCurrency(transactionStore.remainingDailyAmount) }}</div>
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Daily limits: {{ transactionStore.remainingDailyWithdrawals }} withdrawals remaining, max ₱{{ formatCurrency(transactionStore.remainingDailyAmount) }} available
                        </p>
                    </div>
                </div>
            </div>

            <form @submit.prevent="handleSubmit" class="space-y-4">
                <div v-if="error" class="bg-red-50 text-red-600 p-3 rounded-md text-sm">
                    {{ error }}
                </div>
                <div v-if="success" class="bg-green-50 text-green-600 p-3 rounded-md text-sm">
                    {{ success }}
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">₱</span>
                        </div>
                        <input
                            type="number"
                            id="amount"
                            v-model="form.amount"
                            required
                            min="1"
                            step="0.01"
                            class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00"
                        />
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                    <input
                        type="text"
                        id="description"
                        v-model="form.description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                        placeholder="e.g., ATM withdrawal"
                    />
                </div>
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                >
                    {{ loading ? 'Processing...' : 'Withdraw' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useTransactionStore } from '../../stores/transaction';

const transactionStore = useTransactionStore();

const form = reactive({
    amount: '',
    description: '',
});

const loading = ref(false);
const error = ref('');
const success = ref('');

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
};

const handleSubmit = async () => {
    loading.value = true;
    error.value = '';
    success.value = '';
    try {
        const result = await transactionStore.withdraw(parseFloat(form.amount), form.description);
        success.value = `Successfully withdrew ₱${formatCurrency(form.amount)}. Reference: ${result.transaction.reference_number}`;
        form.amount = '';
        form.description = '';
    } catch (e) {
        error.value = e.response?.data?.message || 'Withdrawal failed';
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    transactionStore.fetchBalance();
});
</script>
