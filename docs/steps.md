## create project

- composer create-project laravel/laravel life
- cd money && composer breeze --dev
- composer install breeze

## .env

- change log: daily
- link to local mysql

## auth levels

- add 'auth' Register.vue
- add 'auth' models/User
- add 'auth' migrations/Users
- add AuthLevel Middleware
- add 'auth' RegiserUserController

## add pages

- Pages/todo.vue
- pages/Calendar.vue

## add 'auth' only routes

- skip this step for now, will do once i have 5 accounts (different auth levels) and more pages to switch between 

- ## add todo list

- add 'create todo' button to Pages/Todo.vue
    - add 'form' to 'create todo' button
    - add route to the submit button
- add 'TodoList Controller' to app/http/Controllers
    - add 'create' function
        - create function should add a table to the database? 
        - the new database is linked to another table which allows me to create / edit / delete table (todo list)
        
## created auth layouts 

- didnt work
- tried to create an auth only for calender, will fix later

## todo

- created /js/components/todo/sidebar.vue and main.vue
- buttons in side bar will switch between layouts in main.vue? buttons should be dynamic?
- 

# 9 may 2024

- todo: can use buttons in sidebar to change whats displayed in main











<!-- resources/js/Components/Todo/Main/List.vue -->

<template>
  <div class="todo-container">
    <div class="todo-list-wrapper">
      <div v-for="list in todoList" :key="list.id" class="todo-list">
        <div
          :class="[
            'p-4',
            'border',
            `border-${list.borderColor}`,
            `bg-${list.bgColor}`,
            'rounded-lg',
            'shadow-md',
            'flex',
            'flex-col',
            'space-y-2',
            'w-[15vw]',
            'h-[40vh]',
            'relative',
          ]"
        >
          <button
            @click="deleteList(list.id)"
            class="absolute top-0 right-0 m-2 text-red-500 hover:text-red-700"
          >
            X
          </button>
          <h2 class="text-xl font-bold">{{ list.name }}</h2>
          <ul class="flex flex-col space-y-2">
            <li v-for="word in list.items.split(' ')" :key="word" class="w-full">
              {{ word }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { defineProps } from "vue";

defineProps({
  todoList: Array,
});

const deleteList = (id) => {
  todoList.destroy(`/todoList/${id}`)
    .then(() => {
      // Remove the deleted list from the UI
      todoList.value = todoList.value.filter(list => list.id !== id);
    })
    .catch(error => {
      console.error(error);
    });
};

</script>

<style scoped>
.todo-container {
  overflow-x: scroll; /* Force horizontal scrolling */
  width: 100%; /* You can adjust this based on your design */
  max-width: 100vw; /* Ensure the container doesn't exceed the viewport width */
}

.todo-list-wrapper {
  display: flex;
  flex-wrap: nowrap; /* Prevents lists from wrapping to a new line */
  gap: 1rem; /* Adds some space between the lists */
  width: fit-content; /* Ensures the wrapper takes up the necessary width */
}

.todo-list {
  min-width: fit-content; /* Ensures each list only takes up the necessary width */
}
</style>
