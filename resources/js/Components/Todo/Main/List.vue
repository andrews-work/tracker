<!-- resources/js/Components/Todo/Main/List.vue -->

<template>
    <div class="todo-container">
        <div class="todo-list-wrapper">
            <div v-for="list in todoList" :key="list.id" class="todo-list">

                <!-- card -->
                <div v-if="!showSettings" :class="['p-4','border',`border-${list.borderColor}`,`bg-${list.bgColor}`,'rounded-lg','shadow-md','flex','flex-col','space-y-','w-[15vw]','h-[40vh]','relative']">

                    <!-- nav -->
                    <div class="min-h-[2vh] flex justify-between items-center">
                        <!-- delete list icon -->
                        <div>
                            <font-awesome-icon class="trash-icon" :icon="['fas', 'trash']" @click="deleteList(list.id)" />
                        </div>

                        <!-- show settings icon -->
                        <div>
                            <button @click="showSettings = !showSettings">
                                <font-awesome-icon class="settings-icon" :icon="['fas', 'gear']" />
                            </button>
                        </div>
                    </div>

                    <!-- name -->
                    <div class="min-h-[5vh] pb-2 flex items-center justify-center">
                        <h2 class="text-lg">{{ list.name }}</h2>
                    </div>

                    <!-- list items -->
                    <div class="min-h-[25vh] overflow-y-scroll">
                        <h2 class="text-sm">
                            <ul class="flex flex-col space-y-2">
                                <li v-for="item in list.items" :key="item" class="w-full border-b border-grey-100">{{ item }}</li>
                            </ul>
                        </h2>
                    </div>

                    <!-- folder path-->
                    <div class="min-h-[5vh] py-2 pt-4 flex items-center justify-center">
                        <FontAwesomeIcon :icon="faFolder" class="mr-2" />
                        <h2 class="text-sm pr-2">
                            Personal ->
                        </h2>
                        <FontAwesomeIcon :icon="faFolder" class="mr-2" />
                        <h2 class="text-sm">
                            Car
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
    import { ref, defineProps } from 'vue';
    import { library } from '@fortawesome/fontawesome-svg-core';
    import { faTrash, faGear, faFolder } from '@fortawesome/free-solid-svg-icons';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

    library.add(faTrash, faGear, faFolder);

    const props = defineProps({
        todoList: Array,
    });

    const showSettings = ref(false);

    const deleteList = async (id) => {
        console.log(`Delete list with ID ${id}`);

        // Log the props to check if todoList is defined
        console.log("Props:", props);

        // Use props.todoList instead of todoList
        try {
            const response = await fetch(`/todoList/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (response.ok) {
                console.log(`Deleted list with ID ${id}`);

                // Emit an event to notify the parent component that the delete was successful
                emit('list-deleted', id);
            } else {
                console.error(`Error ${response.status} deleting list ${id}`);
            }
        } catch (error) {
            console.error("Error deleting list:", error);
        }
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

  .trash-icon {
    cursor: pointer; /* This will change the cursor to a pointer when hovering */
    transition: color 0.2s ease; /* This will add a transition effect when changing the color */
  }

  .trash-icon:hover {
    color: red; /* This will change the color to red when hovering */
  }

  .settings-icon {
    cursor: pointer; /* This will change the cursor to a pointer when hovering */
    transition: color 0.2s ease; /* This will add a transition effect when changing the color */
  }

  .settings-icon:hover {
    color: rgb(135, 135, 135); /* This will change the color to red when hovering */
  }

</style>
