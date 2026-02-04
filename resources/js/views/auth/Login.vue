<template>
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Login</h2>
        <form @submit.prevent="handleSubmit" class="space-y-4">
            <div v-if="error" class="bg-red-50 text-red-600 p-3 rounded-md text-sm">
                {{ error }}
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    type="password"
                    id="password"
                    v-model="form.password"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                />
            </div>
            <button
                type="submit"
                :disabled="loading"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
            >
                {{ loading ? 'Signing in...' : 'Sign in' }}
            </button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">
            Don't have an account?
            <router-link to="/register" class="font-medium text-blue-600 hover:text-blue-500">Register</router-link>
        </p>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const form = reactive({
    email: '',
    password: '',
});

const loading = ref(false);
const error = ref('');

const handleSubmit = async () => {
    loading.value = true;
    error.value = '';
    try {
        await authStore.login(form);
        if (authStore.isAdmin) {
            router.push('/admin/dashboard');
        } else {
            router.push('/user/dashboard');
        }
    } catch (e) {
        error.value = e.response?.data?.message || 'Login failed';
    } finally {
        loading.value = false;
    }
};
</script>
