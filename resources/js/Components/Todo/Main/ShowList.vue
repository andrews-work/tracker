<!-- resources/js/Components/Todo/Main/ShowList.vue -->

<template>
<div class="flex space-y-2 py-2 overflow-x-scroll">
  <List :todo-list="todoList" />
</div>

</template>

<script setup>
import List from './List.vue'

defineProps({
  todoList: Array,
})
</script>
