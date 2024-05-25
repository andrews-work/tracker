<!-- resources/js/Components/Todo/Sidebar.vue -->

<template>
  <div class="max-w-8xl mx-auto sm:px-6 lg:px-2 my-4 max-w-full max-h-full h-[83vh] p-6 flex-col overflow-y-scroll">
    <nav class="bg-white border-b border-gray-100 items-center">
      <button @click="onClickListForm" class="bg-white hover:underline text-black font-bold py-1 rounded mb-8">
        Create New List
      </button>
      <button @click="onClickShowList" class="bg-white hover:underline text-black font-bold py-1 rounded">
        Show Lists
      </button>
    </nav>
    <div v-if="showShowList">
      <details class="mt-4">
        <summary>
          <i class="fas fa-folder"></i>
          <span>Categories</span>
        </summary>

        <div class="flex flex-col flex-wrap dropdown-menu">
          <!-- Content for categories -->
          <button @click="filterLists('personal')" class="sidebar-item bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            Personal
          </button>
          <button @click="filterLists('friends')" class="sidebar-item bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            Mates
          </button>
          <button @click="filterLists('family')" class="sidebar-item bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            Family
          </button>
          <button @click="filterLists('business')" class="sidebar-item bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            Business
          </button>
        </div>
      </details>

      <details class="mt-4">
        <summary>
          <i class="fas fa-tags"></i>
          <span>Tags</span>
        </summary>
        <div class="flex flex-col flex-wrap dropdown-menu">
          <!-- Content for tags -->
          <button v-for="tag in tags" :key="tag" @click="filterListsByTag(tag)" class="sidebar-item bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            {{ tag }}
          </button>
        </div>
      </details>

      <details class="mt-4">
        <summary>
          <i class="fas fa-folder"></i>
          <span>Folders</span>
        </summary>
        <div class="flex flex-col flex-wrap dropdown-menu">
          <!-- Content for folders -->
          <button v-for="folder in folders" :key="folder" @click="filterListsByFolder(folder)" class="sidebar-item bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            {{ folder }}
          </button>
        </div>
      </details>

      <details class="mt-4">
        <summary>
          <i class="fas fa-palette"></i>
          <span>Colors</span>
        </summary>
        <div class="flex flex-col flex-wrap dropdown-menu">
          <!-- Content for colors -->
          <button v-for="color in colors" :key="color" @click="filterListsByColor(color)" class="sidebar-item bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-3 rounded-full m-1">
            {{ color }}
          </button>
        </div>
      </details>
    </div>
  </div>
</template>


<script setup>
import { inject, ref, onMounted } from 'vue'
import { faFolder } from '@fortawesome/free-solid-svg-icons'

const showListForm = inject('showListForm')
const showShowList = inject('showShowList')
const showSelectLists = inject('showSelectLists')
const categories = ref(['personal', 'friends', 'family', 'business'])
const selectedCategory = inject('selectedCategory')
const todoList = inject('todoList')

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
  selectedCategory.value = { type: 'folder', value: folder }
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

<style scoped>
/* Add styles for sidebar items */
.sidebar-item {
  width: 150px;
  height: 40px;
  text-align: left; /* Align text to the left */
}

/* Adjust dropdown header styles */
summary {
  outline: none;
  list-style-type: none;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  padding: 0.5rem 1rem; /* Adjust padding */
  margin: 0.5rem -1rem; /* Adjust margin */
}

/* Move the arrow to the right side */
summary .arrow {
  font-size: 1em;
  transition: transform 0.3s ease;
}

summary > .arrow {
  order: 3; /* Move the arrow to the end */
}

details[open] > summary > .arrow {
  transform: rotate(90deg); /* Rotate the arrow */
}

/* Styles for the vertical line */
.dropdown-header {
    position: relative;
    padding-left: 4px;
  }

  /* Adjust the height of the pseudo-element to match the height of the dropdown menu */
  details[open] .dropdown-menu {
    position: relative;
    padding-left: 2vw;
  }

  details[open] .dropdown-menu::before {
    content: "";
    display: block;
    position: absolute;
    left: -2px;
    top: 0;
    height: 100%;
    width: 2px;
    background-color: #d5d5d5;
    margin-left: 0.33vw;
  }
</style>