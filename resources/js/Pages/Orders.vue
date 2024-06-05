<template>

    <Head :title="titulo" />
    <div class="h-full w-full">
        <Navbar />
        <!-- Menú móvil -->
        <div v-show="showMobileMenu" class="md:hidden z-10 fixed top-0 left-0 w-full h-full bg-white overflow-auto">
            <div class="flex items-center justify-center h-full">
                <ul class="text-lg text-center">
                    <li class="my-4">
                        <Link :href="route('models.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Modelos
                        </Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('device.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Dispositivos
                        </Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('order.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Órdenes
                        </Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('reparation.index')" @click="toggleMobileMenu"
                            class="hover:text-gray-600 block">
                        Reparaciones
                        </Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('dashboard')" @click="toggleMobileMenu" class="hover:text-gray-600 block">
                        Dashboard
                        </Link>
                    </li>
                </ul>
            </div>
            <button @click="toggleMobileMenu" class="absolute top-4 right-4 focus:outline-none">
                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <br><br><br>
        <!-- Contenido principal -->
        <div class="pr-4 pl-4">

            <div v-if="showClientModal" class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Información del Cliente
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500"><strong>Nombre: </strong>{{ selectedClient.name
                                            }}</p>
                                        <p class="text-sm text-gray-500"><strong>Email: </strong> {{
        selectedClient.email }}</p>
                                        <p class="text-sm text-gray-500"><strong>Teléfono: </strong> {{
        selectedClient.phone }}</p>
                                        <p class="text-sm text-gray-500"><strong>Dirección: </strong> {{
        selectedClient.adress }}</p>
                                        <p class="text-sm text-gray-500"><strong>Código Postal: </strong> {{
        selectedClient.zip_code }}</p>
                                        <p class="text-sm text-gray-500"><strong>Ciudad: </strong> {{
        selectedClient.city }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="closeClientModal" type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Buscador -->
            <h1 class="text-center text-2xl mb-3">Lista de {{ titulo }}</h1>
            <div class="relative mb-4">
                <input type="text" v-model="searchQuery" placeholder="Buscar..."
                    class="w-fit z-0 py-2 pl-10 pr-4 rounded-full border focus:outline-none focus:border-blue-500 transition duration-300 ease-in-out" />
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 15l4-4m0 0l-4-4m4 4H4"></path>
                    </svg>
                </div>
            </div>

            <!-- Botones de filtro -->
            <div class="flex space-x-2 mb-4">
                <button @click="setStatusFilter('Esperando Aprobación')"
                    :class="['py-2 px-4 rounded-xl', { 'bg-blue-500 text-white': statusFilter === 'Esperando Aprobación', 'bg-gray-200': statusFilter !== 'Esperando Aprobación' }]">
                    Esperando Aprobación
                    <span v-if="pendingApprovalCount > 0"
                        class="text-yellow-800 bg-yellow-300 rounded-full px-2 py-1 ml-1">{{ pendingApprovalCount
                        }}</span>
                </button>

                <button @click="setStatusFilter('En Taller')"
                    :class="['py-2 px-4 rounded-xl', { 'bg-blue-500 text-white': statusFilter === 'En Taller', 'bg-gray-200': statusFilter !== 'En Taller' }]">
                    En Taller
                    <span v-if="inWorkshopCount > 0"
                        class="text-yellow-800 bg-yellow-300 rounded-full px-2 py-1 ml-1">{{ inWorkshopCount }}</span>
                </button>
                <button @click="setStatusFilter('')"
                    :class="['py-2 px-4 rounded-xl', { 'bg-blue-500 text-white': statusFilter === '', 'bg-gray-200': statusFilter !== '' }]">
                    Todos
                </button>
                <select v-model="statusFilter" class="py-2 ml-4 px-4 rounded-lg bg-gray-200">
                    <option value="">Otros Estados</option>
                    <option v-for="status in otherStatuses" :key="status" :value="status">{{ status }}</option>
                </select>

            </div>

            <!-- Botón de añadir -->
            <button @click="toggleAddForm"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl mb-4">
                {{ showAddForm ? 'Cerrar' : '+ Añadir' }}
            </button>

            <!-- Formulario para añadir una nueva orden -->
            <div v-if="showAddForm" class="mb-4">
                <form @submit.prevent="addOrder">
                    <!-- Cliente -->
                    <div class="mb-4 w-fit">
                        <label for="clientSelect" class="block text-gray-700 mb-1">Cliente:</label>
                        <input type="text" v-model="clientSearch" placeholder="Buscar cliente"
                            class="border rounded-md px-3 py-2 w-fit mb-2 mr-1">
                        <select id="clientSelect" v-model="newOrder.user_id" class="border rounded-md px-3 py-2 w-fit">
                            <option :value="client.id" v-for="client in filteredClients" :key="client.id">{{ client.name
                                }}</option>
                        </select>
                    </div>

                    <!-- Reparación -->
                    <div class="mb-4 w-fit">
                        <label for="repairSelect" class="block text-gray-700 mb-1">Reparación:</label>
                        <input type="text" v-model="repairSearch" placeholder="Buscar reparación"
                            class="border rounded-md px-3 py-2 w-fit mb-2 mr-1">
                        <select id="repairSelect" v-model="newOrder.reparation_id"
                            class="border rounded-md px-3 py-2 w-fit">
                            <option :value="repair.id" v-for="repair in filteredRepairs" :key="repair.id">{{ repair.name
                                }}</option>
                        </select>
                    </div>

                    <!-- Fecha de inicio -->
                    <div class="mb-4 w-fit">
                        <label for="orderDate" class="block text-gray-700 mb-1">Fecha de inicio:</label>
                        <input id="orderDate" type="date" v-model="newOrder.order_date"
                            class="border rounded-md px-3 py-2 w-fit">
                    </div>

                    <!-- Estado -->
                    <div class="mb-4 w-fit">
                        <label for="statusSelect" class="block text-gray-700 mb-1">Estado:</label>
                        <select id="statusSelect" v-model="newOrder.status" class="border rounded-md px-3 py-2 w-fit">
                            <option v-for="status in statuses" :value="status">{{ status }}</option>
                        </select>
                    </div>


                    <!-- Fecha de reparación -->
                    <div class="mb-4 w-fit">
                        <label for="reparationDate" class="block text-gray-700 mb-1">Fecha de reparación:</label>
                        <input id="reparationDate" type="date" v-model="newOrder.reparation_date"
                            class="border rounded-md px-3 py-2 w-fit">
                    </div>

                    <!-- Botón para enviar el formulario -->
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl">
                        Guardar
                    </button>
                </form>
            </div>

            <!-- Tabla de órdenes -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border-b cursor-pointer" @click="sortByColumn('id')">#
                                <span v-if="sortBy.column === 'id'">
                                    <span v-if="sortBy.type === 'asc'">&#9650;</span>
                                    <span v-else-if="sortBy.type === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="py-2 px-4 border-b cursor-pointer" @click="sortByColumn('userName')">Cliente
                                <span v-if="sortBy.column === 'userName'">
                                    <span v-if="sortBy.type === 'asc'">&#9650;</span>
                                    <span v-else-if="sortBy.type === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="py-2 px-4 border-b cursor-pointer" @click="sortByColumn('reparation_info')">
                                Reparacion
                                <span v-if="sortBy.column === 'reparation_info'">
                                    <span v-if="sortBy.type === 'asc'">&#9650;</span>
                                    <span v-else-if="sortBy.type === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="py-2 px-4 border-b cursor-pointer" @click="sortByColumn('price')">
                                Precio
                                <span v-if="sortBy.column === 'price'">
                                    <span v-if="sortBy.type === 'asc'">&#9650;</span>
                                    <span v-else-if="sortBy.type === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="py-2 px-4 border-b cursor-pointer" @click="sortByColumn('order_date')">Fecha de
                                inicio
                                <span v-if="sortBy.column === 'order_date'">
                                    <span v-if="sortBy.type === 'asc'">&#9650;</span>
                                    <span v-else-if="sortBy.type === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="py-2 px-4 border-b cursor-pointer" @click="sortByColumn('status')">Estado
                                <span v-if="sortBy.column === 'status'">
                                    <span v-if="sortBy.type === 'asc'">&#9650;</span>
                                    <span v-else-if="sortBy.type === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="py-2 px-4 border-b cursor-pointer" @click="sortByColumn('reparation_date')">Fecha
                                de
                                Reparación
                                <span v-if="sortBy.column === 'reparation_date'">
                                    <span v-if="sortBy.type === 'asc'">&#9650;</span>
                                    <span v-else-if="sortBy.type === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="py-2 px-4 border-b cursor-pointer">
                                Opciones
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(order, index) in paginatedOrders" :key="order.id">
                            <td class="py-2 px-4 border-b">{{ order.id }}</td>
                            <td class="py-2 px-4 border-b" @click="openClientModal(order.user_id)">
                                {{ order.userName }}
                            </td>
                            <td class="py-2 px-4 border-b">
                                <template v-if="editedIndex === index">
                                    <!-- Buscador de reparaciones -->
                                    <input type="text" v-model="editRepairSearch" placeholder="Buscar reparación"
                                        class="border rounded-md px-2 py-1 mb-2 w-full">
                                    <!-- Select para elegir la reparación -->
                                    <select v-model="editedOrder.reparation_info.reparation_id"
                                        class="border rounded-md px-2 py-1 w-full">
                                        <option :value="repair.id" v-for="repair in filteredRepairsEdit"
                                            :key="repair.id">{{ repair.name }}</option>
                                    </select>
                                </template>
                                <template v-else>
                                    {{ order.reparation_info.type + " " + order.reparation_info.model + " " +
        order.reparation_info.device }}
                                </template>
                            </td>
                            <td class="py-2 px-4 border-b">
                                {{ order.reparation_info.price }}€
                            </td>
                            <td class="py-2 px-4 border-b">
                                <template v-if="editedIndex === index">
                                    <input v-model="editedOrder.order_date" class="border rounded-md px-2 py-1" type="date">
                                </template>
                                <template v-else>
                                    {{ order.order_date }}
                                </template>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <template v-if="editedIndex === index">
                                    <select v-model="editedOrder.status" class="border rounded-md px-2 py-1">
                                        <option v-for="status in statuses" :value="status">{{ status }}</option>
                                    </select>
                                </template>
                                <template v-else>
                                    <span :class="getStatusClass(order.status)">
                                        {{ order.status }}
                                    </span>
                                </template>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <template v-if="editedIndex === index">
                                    <input v-model="editedOrder.reparation_date" class="border rounded-md px-2 py-1"
                                        type="date">
                                </template>
                                <template v-else>
                                    {{ order.reparation_date }}
                                </template>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <template v-if="editedIndex === index">
                                    <button @click="updateOrder(index)"
                                        class="px-4 py-2 bg-green-500 text-white rounded-md mr-2"><i
                                            class="fa-regular fa-floppy-disk"></i></button>
                                    <button @click="cancelEdit" class="px-4 py-2 bg-gray-400 text-white rounded-md"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </template>
                                <template v-else>
                                    <button @click="editOrder(index)"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md mr-2"><i
                                            class="fa-regular fa-pen-to-square"></i></button>
                                    <button @click="confirmDelete(order.id)"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md"><i
                                            class="fa-solid fa-trash"></i>
                                    </button>
                                </template>
                            </td>
                        </tr>
                    </tbody>


                </table>
            </div>

            <!-- Paginación -->
            <Pagination :current-page="currentPage" :total-pages="totalPages" :per-page="itemsPerPage"
                @update-items-per-page="updateItemsPerPage" @update-current-page="updateCurrentPage" />
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from './Navbar.vue';
import Pagination from './Pagination.vue';

export default {
    props: {
        titulo: String,
        orders: Array,
        tableName: String,
        users: Array,
        reparations: Array,
    },
    components: {
        Head,
        Link,
        Navbar,
        Pagination
    },
    data() {
        return {
            // Tu código existente
            showClientModal: false,
            editRepairSearch: '', // Buscador para la edición
            selectedClient: null,
            clientSearch: '',
            status: '', // Agrega el campo de estado aquí
            repairSearch: '',
            newOrder: {
                user_id: null,
                reparation_id: null,
                // Agrega más campos según sea necesario
            },
            searchQuery: '',
            showAddForm: false,
            showMobileMenu: false,
            sortBy: {
                column: 'id',
                type: 'asc'
            },
            editedIndex: -1,
            editedOrder: null,
            currentPage: 1,
            itemsPerPage: 10,
            statusFilter: '',
            showEditModal: false,
            selectedOrder: null,
            statuses: ['Esperando Aprobación', 'Aprobado', 'En Envío', 'En Taller', 'Cancelado', 'Reparado', 'Entregado a Cliente']
        };
    },
    computed: {
        filteredClients() {
            const query = this.clientSearch.toLowerCase();
            return this.users.filter(client =>
                client.name.toLowerCase().includes(query)
            );
        },
        filteredRepairs() {
            const query = this.repairSearch.toLowerCase();
            return this.reparations.filter(repair =>
                repair.name.toLowerCase().includes(query)
            );
        },
        // Filtro de reparaciones para el modo de edición
        filteredRepairsEdit() {
            const query = this.editRepairSearch.toLowerCase();
            return this.reparations.filter(repair =>
                repair.name.toLowerCase().includes(query)
            );
        },
        filteredOrders() {
            const query = this.searchQuery.toLowerCase();
            let orders = this.orders;

            if (this.searchQuery) {
                orders = orders.filter(order =>
                    Object.values(order).some(value =>
                        String(value).toLowerCase().includes(query)
                    )
                );
            }

            if (this.statusFilter) {
                orders = orders.filter(order => order.status === this.statusFilter);
            }

            return orders.sort((a, b) => {
                let modifier = 1;
                if (this.sortBy.type === 'desc') modifier = -1;
                if (this.sortBy.column === 'reparation_info') {
                    return modifier * a.reparation_info.type.localeCompare(b.reparation_info.type);
                } else {
                    if (a[this.sortBy.column] < b[this.sortBy.column]) return -1 * modifier;
                    if (a[this.sortBy.column] > b[this.sortBy.column]) return 1 * modifier;
                    return 0;
                }
            });
        },
        paginatedOrders() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredOrders.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredOrders.length / this.itemsPerPage);
        },
        pendingApprovalCount() {
            return this.orders.filter(order => order.status === 'Esperando Aprobación').length;
        },
        inWorkshopCount() {
            return this.orders.filter(order => order.status === 'En Taller').length;
        },
        otherStatuses() {
            return this.statuses.filter(status => status !== 'Esperando Aprobación' && status !== 'En Taller');
        }
    },
    methods: {
        openClientModal(client) {
            const selectedClient = this.users.find(user => user.id === client);
            // Muestra los datos del cliente en la consola
            this.selectedClient = selectedClient;
            this.showClientModal = true;
        },
        closeClientModal() {
            this.showClientModal = false;
            this.selectedClient = null;
        },
        // Método para confirmar la eliminación de una orden
        confirmDelete(orderId) {
            if (confirm("¿Estás seguro de que deseas eliminar esta orden?")) {
                // Llama al método deleteOrder si el usuario confirma la eliminación
                this.deleteOrder(orderId);
            }
        },
        // Método para eliminar una orden
        async deleteOrder(orderId) {
            // Handle delete order logic here
            console.log(orderId);
            try {
                const response = await this.$inertia.delete(`${this.tableName}/${orderId}`);
                console.log('Orden eliminada con éxito:', response);
            } catch (error) {
                console.error('Error al guardar la orden:', error);
            }
        },
        async addOrder() {
            try {
                // Envía los datos de la nueva orden al servidor
                console.log(this.newOrder);
                const response = await this.$inertia.post(`${this.tableName}`, this.newOrder);
                console.log('Orden guardada con éxito:', response);
                // Limpia el formulario después de guardar
                this.newOrder = {
                    user_id: null,
                    repairId: null,
                    order_date: null,
                    status: '',
                    reparation_date: null
                };
                this.toggleAddForm();
            } catch (error) {
                console.error('Error al guardar la orden:', error);
            }
        },
        editOrder(index) {
            this.editedIndex = index;
            // Crear una copia profunda de la orden seleccionada para editar
            this.editedOrder = JSON.parse(JSON.stringify(this.filteredOrders[index]));
        },
        cancelEdit() {
            this.editedIndex = -1;
            this.editedOrder = null; // Limpiar la orden editada
        },
        async updateOrder(index) {
            const orderToUpdate = this.editedOrder;
            console.log('Updated order:', orderToUpdate);
            if (this.tableName) {
                try {
                    const response = await this.$inertia.put(`${this.tableName}/${orderToUpdate.id}`, orderToUpdate);
                    console.log('Cambios guardados exitosamente', response);
                    // Actualizar la orden original con los cambios guardados
                    this.$set(this.filteredOrders, index, orderToUpdate);
                } catch (error) {
                    console.error('Error al guardar cambios:', error);
                }
            } else {
                console.error('this.tableName es undefined');
            }
            this.editedIndex = -1;
            this.editedOrder = null; // Limpiar la orden editada
        },
        getStatusClass(status) {
            switch (status) {
                case 'Esperando Aprobación':
                    return 'p-2 m-4 rounded-lg bg-yellow-200 text-yellow-800';
                case 'Aprobado':
                    return 'p-2 m-4 rounded-lg bg-green-200 text-green-800';
                case 'En Envío':
                    return 'p-2 m-4 rounded-lg bg-blue-200 text-blue-800';
                case 'En Taller':
                    return 'p-2 m-4 rounded-lg bg-purple-200 text-purple-800';
                case 'Cancelado':
                    return 'p-2 m-4 rounded-lg bg-red-200 text-red-800';
                case 'Reparado':
                    return 'p-2 m-4 rounded-lg bg-teal-200 text-teal-800';
                case 'Entregado a Cliente':
                    return 'p-2 m-4 rounded-lg bg-indigo-200 text-indigo-800';
                default:
                    return 'p-2 m-4 rounded-lg bg-gray-200 text-gray-800';
            }
        },
        toggleAddForm() {
            this.showAddForm = !this.showAddForm;
        },
        toggleMobileMenu() {
            this.showMobileMenu = !this.showMobileMenu;
        },
        sortByColumn(column) {
            if (this.sortBy.column === column) {
                this.sortBy.type = this.sortBy.type === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortBy.column = column;
                this.sortBy.type = 'asc';
            }
        },
        setStatusFilter(status) {
            this.statusFilter = status;
            this.currentPage = 1; // Reset to the first page
        },
        updateItemsPerPage(newItemsPerPage) {
            this.itemsPerPage = newItemsPerPage;
            this.currentPage = 1; // Reset to the first page
        },
        updateCurrentPage(newPage) {
            this.currentPage = newPage;
        },
    }
};
</script>


<style>
/* Añade estilos adicionales si es necesario */
</style>
