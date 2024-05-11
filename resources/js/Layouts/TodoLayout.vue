<!-- resources/js/Layouts/TodoLayout.vue -->

<script>
    import Sidebar from '@/Components/Todo/Sidebar.vue';

    export default {
        components: {
            Sidebar,
        },
    };
</script>

<template>
    <div class="flex">
        <div class="w-1/6 bg-white overflow-hidden shadow-sm sm:rounded-lg my-8 ml-8 px-4">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <Sidebar />
            </div>
        </div>
        <div class="w-5/6 h-[80vh] py-8">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full h-full">
                    <div class="p-6 text-gray-900">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>