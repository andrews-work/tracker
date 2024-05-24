<template>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 max-w-full max-h-full bg-black-100">
        <div class="p-6 overflow-y-scroll">
            <form @submit.prevent="createList(form)" class="grid grid-cols-2 gap-4 ">
                <!-- Left section -->
                <div>
                    <!-- name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="name">
                            Name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" v-model="form.name" required ref="name">
                    </div>

                    <!-- category -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="category">
                            Category
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" v-model="form.category" required>
                            <option value="">Select a category</option>
                            <option value="personal">Personal</option>
                            <option value="friends">Friends</option>
                            <option value="family">Family</option>
                            <option value="business">Business</option>
                        </select>
                    </div>

                    <!-- importance -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="importance">
                            Importance
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="importance" v-model="form.importance">
                            <option value="">Select importance</option>
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <!-- date -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="date">
                            Date
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="date" type="date" v-model="form.date">
                        </div>

                        <!-- color -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="color">
                                Color
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="color" type="color" v-model="form.color">
                        <div class="mb-4" v-if="form.color">
                            <p>Chosen color:
                                <span :style="{ backgroundColor: form.color }" class="inline-block w-10 h-10 rounded-full"></span>
                            </p>
                        </div>
                    </div>

                    <!-- folder -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="folder">
                            Folder
                        </label>
                        <input list="folderOptions" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="folder" type="text" v-model="form.folder">
                        <datalist id="folderOptions">
                            <option v-for="option in folderOptions" :key="option" :value="option">
                                {{ option }}
                            </option>
                        </datalist>
                    </div>

                    <!-- subFolder -->
                    <div class="mb-4" v-if="form.folder">
                        <label class="block text-gray-700 font-bold mb-2" for="subFolder">
                            SubFolder
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="subFolder" v-model="form.subFolder">
                            <option value="">Select a subfolder</option>
                            <option v-for="option in getSubFolderOptions(form.folder)" :key="option" :value="option">
                                {{ option }}
                            </option>
                            <option value="new">Add New</option>
                        </select>
                        <div v-if="form.subFolder === 'new'">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="newSubFolder" type="text" v-model="newSubFolder">
                            <button @click="addNewSubFolder">Add</button>
                        </div>
                    </div>

                    <!-- tag -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="tag">
                            Tag
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tag" type="text" v-model="form.tag">
                    </div>

                </div>

                <!-- Right section -->
                <div>
                    <!-- list items -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="items">
                            Items
                        </label>
                        <div class="flex items-center">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="items" type="text" v-model="newItem" @keydown.enter="addItem($event)">
                            <button class="ml-2 bg-blue-500 hover text-white font-bold py-2 px-4 rounded focus focus" @click="addItem">
                                +
                            </button>
                        </div>
                        <ul class="flex flex-col">
                            <li v-for="(item, index) in form.items" :key="index">
                            {{ item }} <button @click="removeItem(index)">Remove</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom section -->
                <div class="col-span-2 flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                        Submit
                    </button>
                    <button type="button" @click="$emit('cancel')" class="bg-red-500 hover text-white font-bold py-2 px-4 rounded focus focus">
                        Cancel
                    </button>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3';

export default {
    data() {
        return {
            newSubFolder: '',
            folderOptions: [], // define folderOptions as an empty array
            subFolderOptions: {}, // define subFolderOptions as an empty object
        }
    },
    methods: {
        addNewSubFolder() {
            if (this.newSubFolder) {
                // ensure that this.subFolderOptions[this.form.folder] is an array before pushing the new subfolder
                if (!Array.isArray(this.subFolderOptions[this.form.folder])) {
                    this.subFolderOptions[this.form.folder] = [];
                }
                this.subFolderOptions[this.form.folder].push(this.newSubFolder);
                this.form.subFolder = this.newSubFolder;
                this.newSubFolder = '';
            }
        },
        // define the getSubFolderOptions method
        getSubFolderOptions(folder) {
            return this.subFolderOptions[folder] || [];
        }
    },
    async created() {
        // Fetch current folders from the server
        try {
            const response = await fetch('/todoList'); // replace with the actual URL

            if (response.ok) {
                const data = await response.json();
                this.folderOptions = data.map(todoList => todoList.folder).filter((value, index, self) => self.indexOf(value) === index);
            } else {
                console.error(`Error ${response.status} fetching folders`);
            }
        } catch (error) {
            console.error("Error fetching folders:", error);
        }
    },


        setup(props) {
            const form = useForm({
            name: '',
            category: '',
            importance: '',
            date: '',
            color: '',
            folder: '',
            subFolder: '',
            tag: '',
            items: [],
            })

            const nameInput = ref(null)
            const categorySelect = ref(null)

            onMounted(() => {
                nameInput.value = document.querySelector('#name')
                categorySelect.value = document.querySelector('#category')
            })

            const createList = () => {
                if (!nameInput.value.checkValidity()) {
                    nameInput.value.reportValidity();
                    return;
                }

                if (categorySelect.value.value === '') {
                    alert('Please select a category');
                    return;
                }

                form.post('/todoList', {
                    onSuccess: () => {
                        console.log('List created successfully');
                        router.push('/todo');
                    },
                    onError: (errors) => {
                        console.error(errors);
                    }
                });
            };

            // add new item
            const newItem = ref('')
            const addItem = (event) => {
                if (newItem.value.trim()) {
                    form.items.push(newItem.value.trim());
                    newItem.value = '';
                }
                event.preventDefault();
            }

            // remove item
            const removeItem = (index) => {
                form.items.splice(index, 1);
            }

            // cancel form
            const cancel = () => {
                form.name = '';
                form.category = '';
                form.importance = '';
                form.date = '';
                form.color = '';
                form.items = [];
                form.folder = '';
                form.subFolder = '';
                form.tag = '';
                newItem.value = '';
            };

            return {
                form,
                createList,
                categories: props.categories,
                cancel,
                newItem,
                addItem,
                removeItem,
            }
        },
    }
</script>
