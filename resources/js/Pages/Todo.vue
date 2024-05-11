<!-- resources/js/Pages/Todo.vue -->

<script setup>
    import { ref, provide, onMounted } from 'vue'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import TodoLayout from '@/Layouts/TodoLayout.vue';
    import Main from '@/Components/Todo/Main.vue';
    // import ShowList from '@/Components/Todo/Main/ShowList.vue';

    const showListForm = ref(false)
    const showShowList = ref(true)

    provide('showListForm', showListForm)
    provide('showShowList', showShowList)

    const todoList = ref([])

    onMounted(() => {
    fetch('/todoList')
        .then(response => response.json())
        .then(data => {
            todoList.value = data
        })
        .catch(error => {
            console.error(error)
        })
    })
</script>

<template>
    <Head title="Todo" />

    <AuthenticatedLayout>
        <TodoLayout>
            <Main :todoList="todoList" />
        </TodoLayout>
    </AuthenticatedLayout>
</template>
