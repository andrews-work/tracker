<!-- resources/js/Components/Todo/Main/List.vue -->

<template>
    <div class="todo-container">
        <div class="todo-list-wrapper">
            <div v-for="list in todoList" :key="list.id" class="todo-list">

                <!-- card -->
                <div v-if="!showSettings" :class="['p-4','border',`border-${list.borderColor}`,`bg-${list.bgColor}`,'rounded-lg','shadow-md','flex','flex-col','space-y-2','w-[15vw]','h-[40vh]','relative']">

                    <!-- nav -->
                    <div class="h-auto flex justify-between items-center">
                        <!-- delete list icon -->
                        <div>
                            <font-awesome-icon :icon="['fas', 'trash']" @click="deleteList(list.id)" />
                        </div>

                        <!-- show settings icon -->
                        <div>
                            <button @click="showSettings = !showSettings">
                                <font-awesome-icon :icon="['fas', 'gear']" />
                            </button>
                        </div>
                    </div>

                    <!-- name -->
                    <div class="border-b border-grey-300 pb-2 h-[5vh] flex items-center justify-center">
                        <h2 class="text-xl">{{ list.name }}</h2>
                    </div>

                    <!-- list items -->
                    <div class=" h-auto">
                        <h2 class="text-xl">
                            <ul class="flex flex-col space-y-2">
                                <li v-for="word in list.items.split(' ')" :key="word" class="w-full">{{ word }}</li>
                            </ul>
                        </h2>
                    </div>

                </div>

                    <!-- card settings -->
                    <div v-if="showSettings" :class="['p-4','border',`border-${list.borderColor}`,`bg-${list.bgColor}`,'rounded-lg','shadow-md','flex','flex-col','space-y-2','w-[15vw]','h-[40vh]','relative']">

                    <!-- color? -->
                    <div class="border border-grey-400 h-[5vh] flex items-center justify-center">
                    </div>

                    <!-- folder? -->
                    <div class="border border-grey-400 h-auto">
                        <h2 class="text-xl">
                        </h2>
                    </div>

                    <!-- folder? -->
                    <div class="border border-grey-400 h-auto">
                        <h2 class="text-xl">
                        </h2>
                    </div>

                    <!-- settings button -->
                    <button @click="showSettings = !showSettings">Hide Settings</button>

                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { library } from '@fortawesome/fontawesome-svg-core';
    import { faTrash, faGear } from '@fortawesome/free-solid-svg-icons';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

    library.add(faTrash, faGear);

    defineProps({
        todoList: Array,
    });

    const showSettings = ref(false);

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
