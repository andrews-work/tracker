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

const selectedCategory = inject('selectedCategory')
const todoList = inject('todoList')

defineProps({
  todoList: Array,
})

const filterListsByCategory = () => {
  if (selectedCategory.value) {
    switch (selectedCategory.value.type) {
      case 'category':
        return todoList.value.filter(list => list.category === selectedCategory.value.value)
      case 'tag':
        return todoList.value.filter(list => list.tags.includes(selectedCategory.value.value))
      case 'color':
        return todoList.value.filter(list => list.color === selectedCategory.value.value)
      case 'folder':
        return todoList.value.filter(list => list.folder === selectedCategory.value.value)
      default:
        return []
    }
  } else {
    return []
  }
}

const filteredLists = computed(() => filterListsByCategory())

const getFilteredLists = () => {
  if (selectedCategory.value) {
    const result = filterListsByCategory()
    console.log(result)
    return result
  }
  return []
}
</script>
