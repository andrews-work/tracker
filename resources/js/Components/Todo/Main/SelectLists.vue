<!-- resources/js/Components/Todo/Main/SelectLists.vue -->

<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">Select Lists</h2>
    <div v-if="filteredLists.length > 0">
      <div v-for="list in filteredLists" :key="list.id" class="bg-white p-4 mb-4 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-2">{{ list.name }}</h3>
        <div v-for="(item, index) in list.items" :key="index" class="flex items-center mb-2">
          <input type="checkbox" :id="`checkbox-${index}`" v-model="item.completed" class="mr-2">
          <label :for="`checkbox-${index}`" class="text-gray-700" :class="{ 'line-through': item.completed }">{{ item.text }}</label>
        </div>
      </div>
    </div>
    <div v-else>
      <p>No lists found for the selected category.</p>
    </div>
  </div>
</template>

<script setup>
import { inject, defineProps, ref, computed } from 'vue'

const showSelectLists = inject('showSelectLists')
const selectedCategory = inject('selectedCategory')

defineProps({
  todoList: Array,
})

const filterListsByCategory = (category) => {
  return todoList.value.filter(list => list.category === category)
}

const filteredLists = computed(() => {
  if (selectedCategory.value) {
    return filterListsByCategory(selectedCategory.value)
  }
  return []
})
</script>
