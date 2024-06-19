<!-- resources/js/Pages/Todo.vue -->

<script setup>
    import { ref, provide, onMounted } from 'vue'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import TodoLayout from '@/Layouts/TodoLayout.vue';
    import Main from '@/Components/Todo/Main.vue';

    const showListForm = ref(false)
    const showShowList = ref(true)
    const showSelectList = ref(false)
    const selectedCategory = ref(null)
    const selectedSidebarButton = ref('showLists');
    const todoList = ref([])

    provide('showListForm', showListForm)
    provide('showShowList', showShowList)
    provide('showSelectLists', showSelectList)
    provide('selectedCategory', selectedCategory) 
    provide('todoList', todoList)  

    onMounted(() => {
    fetch('/todoList')
        .then(response => response.json())
        .then(data => {
        todoList.value = data.map(list => {
            let items = []

            if (typeof list.items === 'string') {
            items = list.items.split('\n') // Split the string by newline characters instead of parsing it as JSON
            } else if (Array.isArray(list.items)) {
            items = list.items
            }

            return {
            ...list,
            items
            }
        })
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
