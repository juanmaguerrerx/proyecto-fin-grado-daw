<template>
    <div>

        <Head :title="titulo" />
        <NavbarCat />
        <div class="min-h-screen bg-gray-100 pt-20">
            <div class="container mx-auto max-w-4xl px-4 py-8">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="flex justify-center items-center h-96">
                        <img :src="getImgSrc(deviceType)" :alt="name" class="object-cover object-center h-96 w-auto">
                    </div>
                    <div class="p-6">
                        <h2 class="text-gray-800 text-2xl font-semibold mb-2">{{ name }}</h2>
                        <p class="text-gray-600 mb-4">Para solicitar esta reparación en el dispositivo seleccionado,
                            pulsa en 'Pedir Reparación'</p>
                        <div class="text-gray-700 font-bold text-xl mb-4">{{ item.price ? item.price + ' €' : '' }}
                        </div>
                        <button @click="handleRepairRequest"
                            class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                            Pedir Reparación
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
                            <Link :href="route('device.indexUser')" class="text-gray-300 hover:text-white">Dispositivos
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
                        <li><a href="https://github.com/juanmaguerrerx" target="_blank"
                                class="text-gray-300 hover:text-white">Repositorio en GitHub</a></li>
                    </ul>
                </div>
            </div>
            <!-- Texto de derechos de autor -->
            <div class="text-center mt-8">
                <p class="text-gray-300">© Juanma Guerrero 2024. Todos los derechos reservados.</p>
            </div>
        </footer>

        <!-- Modal de Confirmación -->
        <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmar Solicitud de Reparación</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Por favor, confirme que los siguientes datos son correctos:
                            </p>
                            <ul class="mt-3 text-sm text-gray-600">
                                <li><strong>Nombre:</strong> {{ user.name }}</li>
                                <li><strong>Teléfono:</strong> {{ user.phone }}</li>
                                <li><strong>Email:</strong> {{ user.email }}</li>
                                <li><strong>Dirección:</strong> {{ user.adress }}</li>
                                <li><strong>Código Postal:</strong> {{ user.zip_code }}</li>
                                <li><strong>Ciudad:</strong> {{ user.city }}</li>
                            </ul>
                        </div>
                        <div class="mt-5 sm:mt-6">
                            <button @click="confirmRepairRequest"
                                class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                                Confirmar
                            </button>
                            <button @click="closeModal"
                                class="inline-flex mt-4 justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-100 text-base font-medium text-blue-600 hover:text-blue-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link, usePage } from '@inertiajs/vue3';
import NavbarCat from './NavbarCat.vue';
import { useToast } from 'vue-toastification';

export default {
    components: {
        NavbarCat,
        Link,
        Head,
    },
    props: {
        item: Object,
        name: String,
        titulo: String,
        deviceType: String,
    },
    setup() {
        const page = usePage();
        const user = page.props.auth.user;
        const toast = useToast();
        return {
            user,
            toast,
        };
    },
    data() {
        return {
            showModal: false,
            order: {} // Mover la inicialización aquí
        };
    },
    methods: {
        getImgSrc(deviceType) {
            if (deviceType === 'Smartphone') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/smartphone/pantalla.webp';
            } else if (deviceType === 'Computer') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/pc/pantallaa.jpg';
            } else if (deviceType === 'Console') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/consola/console.png';
            }
            return 'https://ximg.es/300.png/09f/fff';
        },
        handleRepairRequest() {
            if (!this.user) {
                this.$inertia.get(this.route('login'));
            } else {
                this.showModal = true;
            }
        },
        closeModal() {
            this.showModal = false;
        },
        async confirmRepairRequest() {
            try {
                this.order = {
                    user_id: this.user.id,
                    reparation_id: this.item.id,
                    order_date: new Date().toISOString().slice(0, 10),
                    status: 'Esperando Aprobación'
                };
                await this.$inertia.post(this.route('order.storeUser'), this.order);
                this.closeModal();
                this.toast.success('Orden creada con éxito', {
                    position: "top-right",
                    timeout: 3000,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                });
            } catch (error) {
                console.error("Error al confirmar la reparación:", error);
            }
        },
    },
};
</script>
