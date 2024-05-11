<!-- resources/js/Components/Todo/Main.vue -->

<script setup>
import { inject, defineProps, watch } from 'vue'
import ListForm from './Main/ListForm.vue';
import ShowList from './Main/ShowList.vue';
import ListNav from './Main/ListNav.vue';

const showListForm = inject('showListForm')
const showShowList = inject('showShowList')

const handleCancel = () => {
  showListForm.value = false
  showShowList.value = true
}

defineProps({
  todoList: Array,
})
</script>

<template>
    <div class="max-w-10xl mx-auto sm:px-1 lg:px-1 max-w-full max-h-full h-[82vh]">
      <div class="p-6">
        <div v-if="showListForm">
          <ListForm :categories="categories" @cancel="handleCancel" />
        </div>
        <div v-if="showShowList">
            <div class="py-12">
                <div class="max-w-8xl mx-auto sm:px-4 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 flex flex-col">
                            <div class="mb-4">
                                <ListNav />
                            </div>
                            <ShowList :todoList="todoList" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </template>
  

<script>
    export default {
        props: {
            categories: Array,
        },
    }
</script>