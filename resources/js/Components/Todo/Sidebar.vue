<!-- resources/js/Components/Todo/Sidebar.vue -->

<template>
  <div class="max-w-8xl mx-auto sm:px-6 lg:px-2 my-4 max-w-full max-h-full h-[83vh] p-6">
    <nav class="bg-white border-b border-gray-100 items-center">
      <button @click="onClickListForm" class="bg-white hover:underline text-black font-bold py-1 rounded mb-8">
        Create New List
      </button>
      <button @click="onClickShowList" class="bg-white hover:underline text-black font-bold py-1 rounded">
        Show Lists
      </button>
    </nav>
    <div v-if="showShowList">
      <div class="mt-4">
        <h2 class="text-lg font-semibold">Categories</h2>
        <div class="flex flex-wrap">
          <button @click="filterLists('personal')" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            Personal
          </button>
          <button @click="filterLists('friends')" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            Mates
          </button>
          <button @click="filterLists('family')" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            Family
          </button>
          <button @click="filterLists('business')" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            Business
          </button>
        </div>
      </div>
      <div class="mt-4">
        <h2 class="text-lg font-semibold">Tags</h2>
        <div class="flex flex-wrap">
          <!-- Dynamically render buttons for each tag -->
          <button v-for="tag in tags" :key="tag" @click="filterListsByTag(tag)" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            {{ tag }}
          </button>
        </div>
      </div>
      <div class="mt-4">
        <h2 class="text-lg font-semibold">Folders</h2>
        <div class="flex flex-wrap">
          <!-- Dynamically render buttons for each folder -->
          <button v-for="folder in folders" :key="folder" @click="filterListsByFolder(folder)" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            {{ folder }}
          </button>
        </div>
      </div>
      <div class="mt-4">
        <h2 class="text-lg font-semibold">Colors</h2>
        <div class="flex flex-wrap">
          <!-- Dynamically render buttons for each color -->
          <button v-for="color in colors" :key="color" @click="filterListsByColor(color)" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            {{ color }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { inject, ref, onMounted } from 'vue'

const showListForm = inject('showListForm')
const showShowList = inject('showShowList')
const showSelectLists = inject('showSelectLists')
const categories = ref(['personal', 'friends', 'family', 'business'])

const onClickListForm = () => {
  showListForm.value = true
  showShowList.value = false
  showSelectLists.value = false
  console.log('Create New List button clicked')
}

const onClickShowList = () => {
  showShowList.value = true
  showListForm.value = false
  showSelectLists.value = false
  console.log('Show Lists button clicked')
}

const filterLists = (category) => {
  showSelectLists.value = true
  showShowList.value = false
  showListForm.value = false
  console.log(`Filter lists by category: ${category}`)
}

const filterListsByTag = (tag) => {
  showSelectLists.value = true
  showShowList.value = false
  showListForm.value = false
  console.log(`Filter lists by tag: ${tag}`)
}

const filterListsByFolder = (folder) => {
  showSelectLists.value = true
  showShowList.value = false
  showListForm.value = false
  console.log(`Filter lists by folder: ${folder}`)
}

const filterListsByColor = (color) => {
  showSelectLists.value = true
  showShowList.value = false
  showListForm.value = false
  console.log(`Filter lists by color: ${color}`)
}

const tags = ref([])
const folders = ref([])
const colors = ref([])

onMounted(() => {
  fetch('/todoList')
    .then(response => response.json())
    .then(data => {
      // Process your todo lists here...

      // Extract unique tags, folders, colors, and categories
      const allTags = data.flatMap(list => list.tag);
      const allFolders = data.flatMap(list => list.folder);
      const allColors = data.flatMap(list => list.color);
      const allCategories = data.flatMap(list => list.category);

      tags.value = [...new Set(allTags)];
      folders.value = [...new Set(allFolders)];
      colors.value = [...new Set(allColors)];
      categories.value = [...new Set(allCategories)];
    })
    .catch(error => {
      console.error(error)
    })
})

</script>

