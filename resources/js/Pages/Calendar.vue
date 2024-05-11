<!-- resources/js/Pages/Calendar.vue -->

<script setup>
    import { Head } from '@inertiajs/vue3';
    import AuthLayout from '@/Layouts/AuthLayout.vue';
</script>

<template>
    <Head title="Calendar" />

    <AuthLayout>
        <div class="py-8">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You'r dates r coming !</div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
