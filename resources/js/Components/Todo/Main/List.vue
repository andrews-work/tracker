<!-- resources/js/Components/Todo/Main/List.vue -->

<template>
    <div class="todo-container">
        <div class="todo-list-wrapper">
            <div v-for="list in todoList" :key="list.id" class="todo-list">

                <!-- card -->
                <div v-if="!showSettings" :class="['p-4','border',`border-${list.borderColor}`,`bg-${list.bgColor}`,'rounded-lg','shadow-md','flex','flex-col','space-y-','w-[15vw]','h-[40vh]','relative']">

                    <!-- nav -->
                    <div class="min-h-[2vh] flex justify-between items-center pb-4">
                        <!-- delete list icon -->
                        <div>
                            <font-awesome-icon class="trash-icon" :icon="['fas', 'trash']" @click="deleteList(list.id)" />
                        </div>

                        <!-- importance -->
                        <div class="min-h-[5vh] py-2 pt-4 flex items-center justify-center">
                            <FontAwesomeIcon :icon="faExclamation" class="mr-2" />
                            <h2 class="text-sm">{{ list.importance }}</h2>
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
                    <div class="min-h-[24vh] overflow-y-scroll">
                        <div v-for="(item, itemIndex) in list.items" :key="itemIndex">
                            <!-- Add the 'editing' property here -->
                            <div v-if="!list.items[itemIndex].editing" @click="list.items[itemIndex].editing = !list.items[itemIndex].editing">
                            {{ item }}
                            </div>

                            <div v-else>
                            <input
                                v-model="list.items[itemIndex].value"
                                @blur="list.items[itemIndex].editing = !list.items[itemIndex].editing"
                                @keyup.enter="saveChanges(list, itemIndex, item.value)"
                            />
                            </div>
                        </div>
                        
                    </div>
                    <!-- folder path-->
                    <div class="flex justify-center h-[5vh]">
                        <div class="py-2 pt-4 flex items-center justify-center">
                        <template v-if="list.folder || list.subfolder">
                            <FontAwesomeIcon :icon="faFolder" class="mr-2" v-if="list.folder" />
                            <h2 class="text-sm pr-2" v-if="list.folder">{{ list.folder }}</h2>
                            <FontAwesomeIcon :icon="faFolder" class="mr-2" v-if="list.subfolder" />
                            <h2 class="text-sm" v-if="list.subfolder">{{ list.subfolder }}</h2>
                        </template>
                    </div>

                    <!-- tag -->
                    <div class="py-2 pt-4 flex items-center justify-center">
                        <h2 class="text-sm mr-2">#</h2>
                        <h2 class="text-sm">{{ list.tag }}</h2>
                    </div>
                    </div>


                    

                </div>

                <!-- card settings -->
                <div v-if="showSettings" :class="['p-4','border',`border-${list.borderColor}`,`bg-${list.bgColor}`,'rounded-lg','shadow-md','flex','flex-col','space-y-2','w-[15vw]','h-[40vh]','relative']">

                    <!-- folder -->
                    <div class="border border-grey-400 h-auto">
                    <h2 class="text-md">Folder</h2>
                    <input type="text" v-model="list.folder">
                    </div>

                    <!-- subfolder -->
                    <div class="border border-grey-400 h-auto">
                    <h2 class="text-md">Subfolder</h2>
                    <input type="text" v-model="list.subfolder">
                    </div>

                    <!-- tag -->
                    <div class="border border-grey-400 h-auto">
                    <h2 class="text-md">Tag</h2>
                    <input type="text" v-model="list.tag">
                    </div>

                    <!-- importance -->
                    <div class="border border-grey-400 h-auto">
                    <h2 class="text-md">Importance</h2>
                    <input type="text" v-model="list.importance">
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
    import { faTrash, faGear, faFolder, faTag, faExclamation } from '@fortawesome/free-solid-svg-icons';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

    library.add(faTrash, faGear, faFolder, faTag, faExclamation);

    const props = defineProps({
        todoList: Array,
    });

const getImportanceColor = (importance) => {
  switch (importance.toLowerCase()) {
    case "high":
      return "text-red-500";
    case "middle":
      return "text-yellow-500";
    case "low":
      return "text-green-500";
    default:
      return "text-gray-500";
  }
};


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

    const saveChanges = async (list, itemIndex, originalValue) => {
        // Your existing code here...

        // Send a request to your server to update the database
        try {
            const response = await fetch(`/api/lists/${list.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                // Include the updated data in the request body
                // For example, if you're only updating the item value:
                items: list.items
            })
            });

            if (response.ok) {
            console.log('List updated successfully');
            } else {
            console.error('Error updating list:', response.status, response.statusText);
            }
        } catch (error) {
            console.error('Error sending request:', error);
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
