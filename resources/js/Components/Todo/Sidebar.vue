<!-- resources/js/Components/Todo/Sidebar.vue -->

<template>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-2 my-4 max-w-full max-h-full h-[83vh] p-6">
        <nav class="bg-white border-b border-gray-100 tems-center">
                <button @click="onClickListForm" class="bg-white hover:underline text-black font-bold py-1 rounded mb-8">
                    Create New List
                </button>
                <button @click="onClickShowList" class="bg-white hover:underline text-black font-bold py-1  rounded">
                    Show Lists
                </button>
        </nav>
    </div>
</template>
  
  <script setup>
  import { inject } from 'vue'
  
  const showListForm = inject('showListForm')
  const showShowList = inject('showShowList')
  
  const onClickListForm = () => {
    showListForm.value = true
    showShowList.value = false
    console.log('showListForm value on ListForm button click: ', showListForm.value)
  }
  
  const onClickShowList = () => {
    showShowList.value = true
    showListForm.value = false
    console.log('showShowList value on ShowList button click: ', showShowList.value)
  }
  </script>
  