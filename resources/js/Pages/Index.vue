<template>
    <Head :title="titulo" />
    <div class="h-full w-full">
        <Navbar />
        <!-- Menú móvil -->
        <div v-show="showMobileMenu"
            class="md:hidden z-10 fixed top-0 left-0 w-full h-full bg-white z-10 overflow-auto">
            <div class="flex items-center justify-center h-full">
                <ul class="text-lg text-center">
                    <li class="my-4">
                        <Link :href="route('models.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Modelos</Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('device.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Dispositivos</Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('order.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Órdenes</Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('reparation.index')" @click="toggleMobileMenu"
                            class="hover:text-gray-600 block">Reparaciones</Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('dashboard')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Dashboard</Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('user.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Usuarios</Link>
                    </li>
                </ul>
            </div>
            <button @click="toggleMobileMenu" class="absolute top-4 right-4 focus:outline-none">
                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <br><br><br>
        <!-- Contenido principal -->
        <div class="pr-4 pl-4">
            <h1 class="text-center text-2xl mb-3">Lista de {{ titulo }}</h1>
            <div class="relative mb-4">
                <input type="text" v-model="searchQuery" placeholder="Buscar..."
                    class="w-fit z-0 py-2 pl-10 pr-4 rounded-full border focus:outline-none focus:border-blue-500 transition duration-300 ease-in-out">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 15l4-4m0 0l-4-4m4 4H4"></path>
                    </svg>
                </div>
            </div>
            <div class="mb-2">

                <!-- Filtros específicos para la página de Reparaciones -->
                <div v-if="titulo === 'Reparaciones'" class="mb-4">
                    <p class="text-sm">Filtros</p>
                    <!-- Filtro por Tipo de Reparación -->
                    <select v-model="selectedRepairType" class="rounded-md mr-2">
                        <option value="">Todos los Tipos de Reparación</option>
                        <option v-for="reparationType in reparationTypes" :key="reparationType" :value="reparationType">
                            {{ reparationType }}
                        </option>
                    </select>

                    <!-- Filtro por Modelo de Dispositivo -->
                    <select v-model="selectedDeviceModel" class="rounded-md mr-2">
                        <option value="">Todos los Modelos de Dispositivo</option>
                        <option v-for="model in models" :key="model.id" :value="model.name">
                            {{ model.name }}
                        </option>
                    </select>
                </div>

                <!-- Filtros específicos para la página de Dispositivos -->
                <div v-if="titulo === 'Dispositivos'" class="mb-4">
                    <p class="text-sm">Filtros</p>
                    <!-- Filtro por Tipo de Dispositivo -->
                    <select v-model="selectedDeviceType" class="rounded-md mr-2">
                        <option value="">Todos los Tipos de Dispositivo</option>
                        <option v-for="deviceType in deviceTypes" :key="deviceType" :value="deviceType">
                            {{ deviceType }}
                        </option>
                    </select>

                    <!-- Filtro por Modelo de Dispositivo -->
                    <select v-model="selectedDeviceModel" class="rounded-md mr-2">
                        <option value="">Todos los Modelos de Dispositivo</option>
                        <option v-for="model in models" :key="model.id" :value="model.name">
                            {{ model.name }}
                        </option>
                    </select>
                </div>
                <!-- Botón de añadir -->
                <button v-if="titulo !== 'Usuarios'" @click="toggleAddForm"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl mb-4">
                    {{ showAddForm ? 'Cerrar' : '+ Añadir' }}
                </button>

                <!-- Agrega el formulario -->
                <Form v-if="showAddForm" :fields="formFields" :models="models" :devices="devices"
                    @form-submit="handleAddFormSubmit" />


                <!-- Contenido principal -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="item in paginatedItems" :key="item.id"
                        class="bg-slate-100 rounded-lg shadow-md p-4 hover:shadow-xl transition duration-300 ease-in-out"
                        @click="openModal(item, tableName)">
                        <h2 class="text-xl font-semibold mb-2">{{ item.model ? item.model + ' ' + item.name : item.name
                            }}</h2>
                        <p class="text-gray-600">-- Ver más --</p>
                    </div>
                </div>
            </div>

            <!-- Paginación -->
            <Pagination :currentPage="currentPage" :totalPages="totalPages" :perPage="itemsPerPage"
                @update-items-per-page="updateItemsPerPage" @update-current-page="updateCurrentPage" />
        </div>

        <!-- Modal -->
        <Modal v-if="selectedItem" class="z-20" @close="closeModal" :data="selectedItem" :disableFields="disableFields"
            :tableName="tableName" @delete="handleDelete" @save="handleSave">
            <template v-slot:header>
                <h3>{{ (selectedItem.model ? selectedItem.model : '') + ' ' + selectedItem.name }}</h3>
            </template>
        </Modal>
    </div>
</template>

<script>
import { Head, Link, router } from '@inertiajs/vue3';
import Form from './Form.vue';
import Navbar from './Navbar.vue';
import Modal from './Modal.vue';
import Pagination from './Pagination.vue'; // Importar el componente de paginación

export default {
    props: {
        items: Array,
        titulo: String,
        itemModel: Array,
        tableName: String,
        models: Array,
        devices: Array,
        deviceTypes: Array, // Añade esto
        reparationTypes: Array // Añade esto
    },
    components: {
        Modal,
        Form,
        Link,
        Head,
        Navbar,
        Pagination, // Registrar el componente
    },
    data() {
        return {
            selectedItem: null,
            searchQuery: '',
            showAddForm: false,
            formFields: {},
            item: [],
            selectedDeviceType: '',
            selectedRepairType: '',
            selectedDeviceModel: '',
            showMobileMenu: false,
            currentPage: 1,
            itemsPerPage: 25
        };
    },
    computed: {
        filteredItems() {
            let filteredItems = this.items.filter(item => {
                for (let key in item) {
                    if (item[key] !== null && item[key] !== undefined &&
                        item[key].toString().toLowerCase().includes(this.searchQuery.toLowerCase())) {
                        return true;
                    }
                }
                return false;
            });

            if (this.selectedRepairType !== '') {
                filteredItems = filteredItems.filter(item => {
                    return item.reparation_type === this.selectedRepairType;
                });
            }

            if (this.selectedDeviceModel !== '') {
                if (this.titulo == 'Dispositivos') {
                    filteredItems = filteredItems.filter(item => {
                        return item.model === this.selectedDeviceModel;
                    });
                } else if (this.titulo == 'Reparaciones') {
                    filteredItems = filteredItems.filter(item => {
                        return item.name.includes(this.selectedDeviceModel);
                    });
                }
            }

            if (this.selectedDeviceType !== '') {
                filteredItems = filteredItems.filter(item => {
                    return item.type === this.selectedDeviceType;
                });
            }

            return filteredItems;
        },
        paginatedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredItems.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredItems.length / this.itemsPerPage);
        }
    },
    methods: {
        toggleAddForm() {
            this.showAddForm = !this.showAddForm;
            if (this.showAddForm) {
                this.openAddForm();
            }
        },
        toggleMobileMenu() {
            this.showMobileMenu = !this.showMobileMenu;
        },
        async handleAddFormSubmit(formData) {
            console.log(formData);
            try {
                const response = await this.$inertia.post(`${this.tableName}`, formData);
                console.log('FormData: ', formData);
                console.log('Cambios guardados exitosamente', response);
            } catch (error) {
                console.error('Error al guardar cambios:', error);
            }
        },
        openAddForm() {
            this.item = this.items[0];
            this.formFields = {};

            this.formFields = Object.keys(this.item);
            console.log(this.formFields);

            this.showAddForm = true;
        },
        openModal(item, tableName) {
            console.log('tableName: ', tableName);
            this.selectedItem = item;
            this.tableName = tableName;
        },
        closeModal() {
            this.selectedItem = null;
        },
        toggleEdit(item) {
            this.selectedItem = item;
            this.disableFields = false;
        },
        async handleDelete() {
            if (this.selectedItem && this.selectedItem.id) {
                const itemId = this.selectedItem.id;
                console.log(`${this.tableName}/${itemId}`);
                try {
                    const response = await this.$inertia.delete(`${this.tableName}/${itemId}`);
                    console.log('Elemento eliminado exitosamente', response);
                    this.selectedItem = null;
                } catch (error) {
                    console.error('Error al eliminar el elemento:', error);
                }
            } else {
                console.error('No item selected or item ID missing.');
            }
        },
        async handleSave(updatedData) {
            if (this.tableName) {
                try {
                    const response = await this.$inertia.put(`${this.tableName}/${updatedData.id}`, updatedData);
                    console.log('Cambios guardados exitosamente', response);
                    this.closeModal();
                } catch (error) {
                    console.error('Error al guardar cambios:', error);
                }
            } else {
                console.error('this.tableName es undefined');
            }
        },
        updateItemsPerPage(newItemsPerPage) {
            this.itemsPerPage = newItemsPerPage;
            this.currentPage = 1;
        },
        updateCurrentPage(newPage) {
            this.currentPage = newPage;
        }
    }
}
</script>
