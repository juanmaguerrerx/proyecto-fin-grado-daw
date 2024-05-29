<template>
    <div>
        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!! -->
        <!-- FALTA EL FORMULARIO DE REPARACION AL HACER CLIC EN EL (AQUI FUNCION PARA LLEVAR AL FORM) -->
        <!-- MAS QUE FORMULARIO ES COMO UNA MUESTRA QUE DE LA OPCION DE PEDIR, QUE LLEVE A LA PAGINA DE FORMULARIO, COMO EN UNA TIENDA AL MOSTRAR ARTICULO         -->
        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!! -->
        
        <Head :title="titulo" />
        <NavbarCat />
        <div class="min-h-screen bg-gray-100 pt-20">
            <!-- Agrega el botón para mostrar/ocultar los filtros -->
            <!-- Botón para mostrar/ocultar los filtros -->
            <button @click="toggleFilters" v-if="titulo != 'Modelos'"
                class="block m-4 bg-gray-700  text-white py-2 px-4 rounded">
                {{ showFilters ? 'Ocultar Filtros' : 'Mostrar Filtros' }}
            </button>

            <!-- Agrega los filtros dentro de un div con v-if="showFilters" para mostrarlos solo cuando se active -->
            <div v-if="showFilters && titulo != 'Modelos'" class="mt-2 ml-4">
                <!-- Agrega el select para filtrar por modelo -->
                <select v-if="titulo != 'Reparaciones'" v-model="selectedModel" @change="applyFilters"
                    class="w-3/4 md:w-auto py-2 border border-gray-300 rounded mb-2 mr-2 text-center">
                    <option value="">Todos los modelos</option>
                    <option v-for="model in models" :key="model.id" :value="model.id">{{ model.name }}</option>
                </select>

                <!-- Agrega el select para filtrar por tipo de dispositivo -->
                <select v-model="selectedType" @change="applyFilters"
                    class="w-3/4 md:w-auto py-2 border border-gray-300 rounded mb-2 mr-2 text-center">
                    <option value="">Todos los tipos</option>
                    <option v-for="type in deviceTypes" :key="type" :value="type">{{ type }}</option>
                </select>

                <!-- Agrega el select para filtrar por tipo de reparación -->
                <select v-model="selectedReparationType" v-if="titulo == 'Reparaciones'" @change="applyFilters"
                    class="w-3/4 md:w-auto py-2 border border-gray-300 rounded mb-2 mr-2 text-center">
                    <option value="">Todos los tipos de reparación</option>
                    <option v-for="type in reparationTypes" :key="type" :value="type">{{ type }}</option>
                </select>

                <!-- Agrega los inputs para establecer el rango de precios -->
                <div v-if="titulo == 'Reparaciones'" class="flex">
                    <input v-model.number="minPrice" @change="applyFilters" type="number" placeholder="Precio mínimo"
                        class="w-3/4 md:w-40 py-2 border border-gray-300 rounded mb-1 text-center" />
                        <div class="mx-4 mt-2">-</div>
                    <input v-model.number="maxPrice" @change="applyFilters" type="number" placeholder="Precio máximo"
                        class="w-3/4 md:w-40 py-2 border border-gray-300 rounded mb-1 text-center" />
                </div>
            </div>

            <div class="container mx-auto max-w-max px-14 mt-1 py-8">
                <h1 class="text-center text-2xl m-8">{{ titulo }}</h1>
                <div class="mb-4">
                    <input type="text" v-model="searchQuery" placeholder="Buscar..."
                        class="w-full p-2 border border-gray-300 rounded" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
                    <!-- Iterar sobre los elementos y mostrarlos como elementos de tienda -->
                    <div v-if="filteredItems.length > 0" v-for="item in paginatedFilteredItems" :key="item.id"
                        class="bg-white rounded-lg overflow-hidden hover:shadow-xl hover:scale-105 transition-all duration-300 mx-4 cursor-pointer"
                        @click="handleItemClick(item)">
                        <template v-if="titulo === 'Modelos'">
                            <div class="w-full h-64 pr-14 pl-14 bg-gray-200 flex items-center justify-center">
                                <h2 class="text-gray-800 text-lg font-semibold">{{ item.name }}</h2>
                            </div>
                        </template>
                        <template v-else>
                            <img :src="getImgSrc(item)" :alt="item.name" class="w-full h-64 object-cover object-center">
                        </template>
                        <div class="p-4">
                            <h2 class="text-gray-800 text-lg font-semibold">{{ item.model ? item.model + ' ' +
            item.name
            : item.name }}</h2>
                            <p class="mt-2 text-gray-600">{{ item.description }}</p>
                            <div class="mt-4">
                                <span class="text-gray-700 font-bold">{{ item.price ? item.price + " €" : '' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hcer que esté centrado!!!! -->
                    <div v-else>
                        <h1 class="text-center text-2xl m-8">{{ 'No hay ' + titulo + ' que mostrar :(' }}</h1>
                    </div>
                </div>
                <!-- Pagination Component -->
                <Pagination :currentPage="currentPage" :totalPages="totalPages" :perPage="itemsPerPage"
                    @update-items-per-page="updateItemsPerPage" @update-current-page="updateCurrentPage" />
            </div>
        </div>
        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8 pl-14">
            <div class="container mx-auto grid grid-cols-1 lg:grid-cols-3 gap-4 px-6">
                <!-- Enlaces del catálogo -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Catálogo</h3>
                    <ul>
                        <li>
                            <Link :href="route('index')" class="text-gray-300 hover:text-white">Inicio</Link>
                        </li>
                        <li>
                            <Link :href="route('device.indexUser')" class="text-gray-300 hover:text-white">
                            Dispositivos
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('models.indexUser')" class="text-gray-300 hover:text-white">Modelos
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('catalogue')" class="text-gray-300 hover:text-white">Todo</Link>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Administración</h3>
                    <ul v-if="user">
                        <li>
                            <Link :href="route('profile.edit')" class="text-gray-300 hover:text-white">Perfil</Link>
                        </li>
                        <li>
                            <Link :href="route('logout')" method="post" as="button"
                                class="text-gray-300 hover:text-white">
                            Cerrar Sesión
                            </Link>
                        </li>
                    </ul>
                    <ul v-else>
                        <li>
                            <Link :href="route('login')" class="text-gray-300 hover:text-white">Iniciar Sesión</Link>
                        </li>
                        <li>
                            <form :action="route('register')" method="POST">
                                <button type="submit" class="text-gray-300 hover:text-white">Regístrate</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- Enlaces a redes sociales -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Redes sociales</h3>
                    <ul>
                        <li>
                            <Link href="#" class="text-gray-300 hover:text-white">Facebook</Link>
                        </li>
                        <li>
                            <Link href="#" class="text-gray-300 hover:text-white">X</Link>
                        </li>
                        <li>
                            <Link href="#" class="text-gray-300 hover:text-white">Instagram</Link>
                        </li>
                        <li>
                            <a href="https://github.com/juanmaguerrerx" target="_blank" class="text-gray-300 hover:text-white">Repositorio en GitHub</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Texto de derechos de autor -->
            <div class="text-center mt-8">
                <p class="text-gray-300">© Juanma Guerrero 2024. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</template>

<script>
import { Head, Link, usePage } from '@inertiajs/vue3';
import NavbarCat from './NavbarCat.vue';
import Pagination from './Pagination.vue'; // Importa el componente de paginación aquí

export default {
    components: {
        NavbarCat,
        Link,
        Head,
        Pagination, // Registra el componente de paginación
    },
    props: {
        items: Array,
        titulo: String,
        itemModel: Array,
        tableName: String,
        models: Array,
        devices: Array,
        deviceTypes: Array,
        reparationTypes: Array,
    },
    setup() {
        const page = usePage();
        const user = page.props.auth.user;
        return {
            user,
        };
    },
    data() {
        return {
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 5,
            selectedModel: '',
            selectedType: '',
            selectedReparationType: '',
            minPrice: null,
            maxPrice: null,
            showFilters: false, // Agrega la propiedad para controlar la visibilidad de los filtros
        };
    },
    computed: {
        filteredItems() {
            return this.items.filter(item => {
                const searchQuery = this.searchQuery.toLowerCase().trim();
                const matchSearchQuery =
                    !searchQuery ||
                    [item.name, item.description, item.modelName || item.model].some(
                        field => field && field.toLowerCase().includes(searchQuery)
                    );
                const matchModel = !this.selectedModel || item.model_id === this.selectedModel;
                const matchType = !this.selectedType || item.type === this.selectedType;
                const matchReparationType = !this.selectedReparationType || item.reparation_type === this.selectedReparationType;
                const matchPrice =
                    (this.minPrice === null || item.price >= this.minPrice) &&
                    (this.maxPrice === null || item.price <= this.maxPrice);
                return matchSearchQuery && matchModel && matchType && matchReparationType && matchPrice;
            });
        },
        paginatedFilteredItems() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.filteredItems.slice(startIndex, endIndex);
        },
        totalPages() {
            return Math.ceil(this.filteredItems.length / this.itemsPerPage);
        },
    },
    methods: {
        getImgSrc(item) {
            if (item.type === 'Smartphone') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/smartphone/pantalla.webp';
            } else if (item.type === 'Computer') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/pc/pantallaa.jpg';
            } else if (item.type === 'Console') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/consola/console.png';
            }
            return 'https://ximg.es/300.png/09f/fff';
        },
        updateItemsPerPage(newPerPage) {
            this.itemsPerPage = newPerPage;
        },
        updateCurrentPage(newPage) {
            this.currentPfage = newPage;
        },
        handleItemClick(item) {
            if (this.titulo === 'Modelos') {
                console.log(item);
                this.navigateToPage('device.indexUserFilter', item.id);
            } else if (this.titulo === 'Dispositivos') {
                this.navigateToPage('reparation.indexUserFilter', item.id);
            }else if (this.titulo === 'Reparaciones') {
                this.navigateToPage('reparation.view', item.id);
            }
        },
        navigateToPage(routeName, params) {
            this.$inertia.get(this.route(routeName, params));
        },
        toggleFilters() {
            this.showFilters = !this.showFilters;
        },
        applyFilters() {
            this.currentPage = 1;
        },
    },
};
</script>