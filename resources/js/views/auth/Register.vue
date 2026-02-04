<template>
    <div>
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
            <p class="mt-2 text-sm text-gray-600">Join ATM Banking today</p>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-5">
            <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start space-x-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ error }}</span>
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        required
                        placeholder="Enter your full name"
                        class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                    />
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                    <input
                        type="email"
                        id="email"
                        v-model="form.email"
                        required
                        placeholder="Enter your email"
                        class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            v-model="form.password"
                            required
                            minlength="8"
                            placeholder="Min. 8 characters"
                            class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                        />
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            required
                            placeholder="Confirm password"
                            class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                        />
                    </div>
                </div>
            </div>

            <div>
                <label for="pin" class="block text-sm font-medium text-gray-700 mb-2">
                    <span>Transaction PIN</span>
                    <span class="text-gray-400 font-normal ml-1">(6 digits)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <input
                        type="password"
                        id="pin"
                        v-model="form.pin"
                        required
                        maxlength="6"
                        pattern="[0-9]{6}"
                        placeholder="Enter 6-digit PIN"
                        class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-gray-50 focus:bg-white tracking-widest"
                    />
                </div>
                <p class="mt-1 text-xs text-gray-500">This PIN will be used for transaction verification</p>
            </div>

            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="show_password"
                    v-model="showPassword"
                    class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                />
                <label for="show_password" class="ml-2 block text-sm text-gray-600">Show passwords</label>
            </div>

            <button
                type="submit"
                :disabled="loading"
                class="w-full flex justify-center items-center space-x-2 py-3 px-4 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40"
            >
                <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ loading ? 'Creating account...' : 'Create account' }}</span>
            </button>
        </form>

        <div class="mt-8">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Already have an account?</span>
                </div>
            </div>

            <div class="mt-6">
                <router-link
                    to="/login"
                    class="w-full flex justify-center items-center space-x-2 py-3 px-4 border-2 border-emerald-600 rounded-xl text-sm font-semibold text-emerald-600 hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Sign in instead</span>
                </router-link>
            </div>
        </div>
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
const showPassword = ref(false);

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
