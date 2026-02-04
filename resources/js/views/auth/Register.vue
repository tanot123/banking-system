<template>
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Register</h2>
        <form @submit.prevent="handleSubmit" class="space-y-4">
            <div v-if="error" class="bg-red-50 text-red-600 p-3 rounded-md text-sm">
                {{ error }}
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                />
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
                    minlength="8"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                />
            </div>
            <div>
                <label for="pin" class="block text-sm font-medium text-gray-700">PIN (6 digits)</label>
                <input
                    type="password"
                    id="pin"
                    v-model="form.pin"
                    required
                    maxlength="6"
                    pattern="[0-9]{6}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                />
            </div>
            <button
                type="submit"
                :disabled="loading"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
            >
                {{ loading ? 'Creating account...' : 'Create account' }}
            </button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account?
            <router-link to="/login" class="font-medium text-blue-600 hover:text-blue-500">Sign in</router-link>
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
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    pin: '',
});

const loading = ref(false);
const error = ref('');

const handleSubmit = async () => {
    loading.value = true;
    error.value = '';
    try {
        await authStore.register(form);
        router.push('/user/dashboard');
    } catch (e) {
        error.value = e.response?.data?.message || Object.values(e.response?.data?.errors || {}).flat().join(', ') || 'Registration failed';
    } finally {
        loading.value = false;
    }
};
</script>
