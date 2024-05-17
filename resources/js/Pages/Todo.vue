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

    provide('showListForm', showListForm)
    provide('showShowList', showShowList)
    provide('showSelectLists', showSelectList)
    provide('selectedCategory', selectedCategory) 

    const todoList = ref([])

    onMounted(() => {
    fetch('/todoList')
        .then(response => response.json())
        .then(data => {
            todoList.value = data.map(list => {
                let items = []

                if (typeof list.items === 'string') {
                    try {
                        items = JSON.parse(list.items)
                    } catch (error) {
                        console.error(error)
                    }
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
