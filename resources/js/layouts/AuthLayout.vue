<template>
    <div class="min-h-screen bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-md w-full relative z-10">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-2xl flex items-center justify-center shadow-2xl shadow-emerald-500/30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-white">ATM Banking System</h1>
                <p class="mt-2 text-emerald-200">Secure, Fast, Reliable</p>
            </div>

            <div class="bg-white/95 backdrop-blur-xl shadow-2xl rounded-2xl p-8 border border-white/20">
                <router-view />
            </div>

            <p class="mt-6 text-center text-sm text-emerald-200">
                © 2026 ATM Banking System. All rights reserved.
            </p>
        </div>
    </div>
</template>

<script setup>
</script>
