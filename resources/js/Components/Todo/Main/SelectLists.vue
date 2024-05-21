<!-- resources/js/Components/Todo/Main/SelectLists.vue -->

<template>
  <div class="flex space-x-2 py-2 overflow-x-scroll">
    <div class="flex" v-if="getFilteredLists().length > 0">
      <List v-for="list in filteredLists" :key="list.id" :todo-list="[list]" class="flex-row mr-4" />
    </div>
    <div v-else>
      <p>No lists found for the selected category.</p>
    </div>
  </div>
</template>


<script setup>
import { inject, defineProps, ref, computed } from 'vue'
import List from './List.vue'

const showSelectLists = inject('showSelectLists')
const selectedCategory = inject('selectedCategory')
const todoList = inject('todoList')

defineProps({
  todoList: Array,
})

const filterListsByCategory = (category) => {
  return todoList.value.filter(list => {
    if (selectedCategory.value) {
      switch (selectedCategory.value.type) {
        case 'category':
          return list.category === selectedCategory.value.value
        case 'tag':
          return list.tags.includes(selectedCategory.value.value)
        case 'color':
          return list.color === selectedCategory.value.value
        case 'folder':
          return list.folder === selectedCategory.value.value
        default:
          return false
      }
    } else {
      return list.category === category
    }
  })
}

const filteredLists = computed(() => {
  if (selectedCategory.value) {
    return filterListsByCategory(selectedCategory.value)
  }
  return []
})

const getFilteredLists = () => {
  if (selectedCategory.value) {
    const result = filterListsByCategory(selectedCategory.value)
    console.log(result)
    return result
  }
  return []
}
</script>
