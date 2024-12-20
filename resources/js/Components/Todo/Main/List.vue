<!-- resources/js/Components/Todo/Main/List.vue -->

<template>
    <div class="todo-container">
      <div class="todo-list-wrapper">
        <div v-for="list in todoList" :key="list.id" class="todo-list">
  
          <!-- card -->
          <div v-if="!list.showSettings" :class="['p-4','border','rounded-lg','shadow-md','flex','flex-col','space-y-','w-[15vw]','h-[50vh]','relative']" :style="changeBorderColor(list)">
  
            <!-- nav -->
            <div class="min-h-[2vh] flex justify-between items-center pb-4">  
              <!-- show settings icon -->
              <div>
                <button @click="list.showSettings = !list.showSettings">
                  <font-awesome-icon class="settings-icon" :icon="['fas', 'gear']" :style="{ color: getImportanceColor(list.importance) }" />
                </button>
              </div>
            </div>
  
            <!-- name -->
            <div class="min-h-[5vh] pb-2 flex items-center justify-center">

                <div v-if="!list.editingName" @click="list.editingName = true">
                    <h2 class="text-lg text-underline">{{ list.name }}</h2>
                </div>

                <div v-else>
                    <input
                        v-model="list.name"
                        @blur="list.editingName = false"
                        @keyup.enter="saveChanges(list)"
                    />
                </div>
            </div>
  
            <!-- list items -->
            <div class="min-h-[34vh] overflow-y-scroll">
              <div v-for="(item, itemIndex) in list.items" :key="itemIndex">
                <div v-if="!list.items[itemIndex].editing" @click="list.items[itemIndex].editing = !list.items[itemIndex].editing" v-html="item.replace(/\\n/g, '<br>')"></div>

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
          <div v-if="list.showSettings" :class="['p-4','border',`border-${list.borderColor}`,`bg-${list.bgColor}`,'rounded-lg','shadow-md','flex','flex-col','space-y-2','w-[15vw]','h-[50vh]','relative']">
  
            <!-- delete list icon -->
            <div class="flex justify-between">
              <!-- left -->
              <div>
                <button @click="list.showSettings = !list.showSettings">
                  <font-awesome-icon class="settings-icon" :icon="['fas', 'gear']" :style="{ color: getImportanceColor(list.importance) }" />
                </button>
              </div>
              <!-- right? -->
              <div>
                <font-awesome-icon class="trash-icon" :icon="['fas', 'trash']" @click="deleteList(list.id)" />
              </div>
            </div>

            <div class="border border-grey-400 h-auto">
              <h2 class="text-md">Category</h2>
              <select v-model="list.category">
                <option value="mates">Mates</option>
                <option value="family">Family</option>
                <option value="business">Business</option>
                <option value="personal">Personal</option>
              </select>
            </div>
  
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
              <select v-model="list.importance">
                <option value="">Select importance</option>
                <option value="high">High</option>
                <option value="middle">Middle</option>
                <option value="low">Low</option>
              </select>
            </div>

            <!-- color -->
            <div class="border border-grey-400 h-auto">
            <h2 class="text-md">Color</h2>
            <input type="color" v-model="list.borderColor" @input="changeBorderColor(list)">
          </div>
          </div>
  
        </div>
      </div>
    </div>
  </template>
  
<script setup>
  import { ref, defineProps, onMounted, watch } from 'vue';
  import { library } from '@fortawesome/fontawesome-svg-core';
  import { faTrash, faGear, faFolder, faTag, faExclamation } from '@fortawesome/free-solid-svg-icons';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

  library.add(faTrash, faGear, faFolder, faTag, faExclamation);

  const props = defineProps({
    todoList: Array,
  });

  // Don't overwrite the todoList prop, use a different name for the ref
  const todoListWithSettings = ref(props.todoList.map(list => ({ ...list, showSettings: false })));

  const importanceColors = {
    high: 'red',
    middle: 'orange',
    low: 'blue',
  };

  const getImportanceColor = (importance) => {
    return importanceColors[(importance || '').toLowerCase()] || 'black';

  };

  const initShowSettings = () => {
    todoListWithSettings.value.forEach(list => {
      list.showSettings = false;
    });
  };

  onMounted(() => {
    initShowSettings();
  });

  watch(() => props.todoList, () => {
    todoListWithSettings.value = props.todoList.map(list => ({ ...list, showSettings: false }));
  }, { deep: true });
  
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
  
  // update list
  const todoListCopy = ref(JSON.parse(JSON.stringify(props.todoList)));

  const saveChanges = async (list, itemIndex, originalValue) => {
    // Modify the local copy of the todoList instead of the prop
    const updatedItems = todoListCopy.value.map((item, index) => {
      if (index === itemIndex) {
        return {
          ...item,
          value: item.value.trim() || originalValue // If the new value is only whitespace, use the original value
        };
      }
      return item;
    });

    // Send request to controller
    try {
      const response = await fetch(`/api/lists/${list.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          // Include the updated data in the request body
          name: list.name,
          items: updatedItems
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

  const changeBorderColor = (list) => {
    if (list.borderColor) {
      return {
        borderColor: list.borderColor
      };
    } else {
      return {
        borderColor:'border-grey-600'
      };
    }
  }
</script>
  
<style scoped>
  .todo-container {
    overflow-x: scroll;
    width: 100%;
    max-width: 100vw;
  }

  .todo-list-wrapper {
    display: flex;
    flex-wrap: nowrap;
    gap: 1rem;
    width: fit-content;
  }

  .todo-list {
    min-width: fit-content;
  }

  .trash-icon {
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .trash-icon:hover {
    color: red;
  }

  .settings-icon {
    cursor: pointer;
    transition: color 0.2s ease; 
  }

  .settings-icon:hover {
    color: rgb(135, 135, 135);
  }
</style>
  