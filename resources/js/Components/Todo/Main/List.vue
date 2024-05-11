<!-- resources/js/Components/Todo/Main/List.vue -->

<template>
    <div class="todo-container">
        <div class="todo-list-wrapper">
            <div v-for="list in todoList" :key="list.id" class="todo-list">
                <div :class="['p-4','border',`border-${list.borderColor}`,`bg-${list.bgColor}`,'rounded-lg','shadow-md','flex','flex-col','space-y-2','w-[15vw]','h-[40vh]','relative']">
                    <div class="border border-grey-400 h-[5vh]">
                        <h2 class="text-xl">{{ list.name }}</h2>
                    </div>
                    <div class="border border-grey-400 h-auto">
                        <h2 class="text-xl">
                            <ul class="flex flex-col space-y-2">
                                <li v-for="word in list.items.split(' ')" :key="word" class="w-full">{{ word }}</li>
                            </ul>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>

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


<!-- <button
                    @click="deleteList(list.id)"
                    class="absolute top-0 right-0 m-2 text-red-500 hover:text-red-700"
                  >
                    X
                  </button>
                  
                   -->