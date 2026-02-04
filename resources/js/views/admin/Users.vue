<template>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">User Accounts</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div v-if="adminStore.loading" class="p-6 text-center text-gray-500">Loading...</div>
            <table v-else class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in adminStore.users" :key="user.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                            {{ user.account_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ user.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ user.email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-green-600">
                            ₱{{ formatCurrency(user.balance) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                :class="user.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                            >
                                {{ user.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                            <router-link :to="`/admin/users/${user.id}`" class="text-blue-600 hover:text-blue-900">View</router-link>
                            <button @click="toggleStatus(user.id)" class="text-orange-600 hover:text-orange-900">
                                {{ user.is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </td>
                    </tr>
                    <tr v-if="adminStore.users.length === 0">
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No users found</td>
                    </tr>
                </tbody>
            </table>

            <div v-if="adminStore.usersPagination && adminStore.usersPagination.last_page > 1" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button @click="changePage(adminStore.usersPagination.current_page - 1)" :disabled="adminStore.usersPagination.current_page === 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                        Previous
                    </button>
                    <button @click="changePage(adminStore.usersPagination.current_page + 1)" :disabled="adminStore.usersPagination.current_page === adminStore.usersPagination.last_page" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                        Next
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Page <span class="font-medium">{{ adminStore.usersPagination.current_page }}</span> of <span class="font-medium">{{ adminStore.usersPagination.last_page }}</span>
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            <button @click="changePage(adminStore.usersPagination.current_page - 1)" :disabled="adminStore.usersPagination.current_page === 1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                                Previous
                            </button>
                            <button @click="changePage(adminStore.usersPagination.current_page + 1)" :disabled="adminStore.usersPagination.current_page === adminStore.usersPagination.last_page" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
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

const changePage = (page) => {
    adminStore.fetchUsers(page);
};

const toggleStatus = async (id) => {
    await adminStore.toggleUserStatus(id);
};

onMounted(() => {
    adminStore.fetchUsers();
});
</script>
