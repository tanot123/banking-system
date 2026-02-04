<template>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-500">Account Number</div>
                <div class="mt-2 text-lg font-semibold text-gray-900">{{ transactionStore.accountNumber }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-500">Current Balance</div>
                <div class="mt-2 text-2xl font-bold text-green-600">₱{{ formatCurrency(transactionStore.balance) }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-500">Today's Withdrawals</div>
                <div class="mt-2 text-lg font-semibold text-gray-900">{{ transactionStore.todayWithdrawalCount }} / 3</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-500">Remaining Daily Limit</div>
                <div class="mt-2 text-lg font-semibold text-gray-900">₱{{ formatCurrency(transactionStore.remainingDailyAmount) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <router-link to="/user/deposit" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Deposit</h3>
                        <p class="text-sm text-gray-500">Add money to your account</p>
                    </div>
                </div>
            </router-link>

            <router-link to="/user/withdraw" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Withdraw</h3>
                        <p class="text-sm text-gray-500">Withdraw from your account</p>
                    </div>
                </div>
            </router-link>
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

onMounted(() => {
    transactionStore.fetchBalance();
});
</script>
