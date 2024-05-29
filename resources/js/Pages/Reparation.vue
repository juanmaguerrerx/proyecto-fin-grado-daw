<template>
    <div>

        <Head :title="titulo" />
        <NavbarCat />
        <div class="min-h-screen bg-gray-100 pt-20">
            <div class="container mx-auto max-w-4xl px-4 py-8">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    {{ console.log(item) }}
                    <img :src="getImgSrc(item)" :alt="item.name" class="w-full h-96 object-cover object-center">
                    <div class="p-6">
                        <h2 class="text-gray-800 text-2xl font-semibold mb-2">{{ name }}</h2>
                        <p class="text-gray-600 mb-4">Para solicitar esta reparación en el dispositivo seleccionado,
                            debe Pedir Reparación rellenando el formulario correspondiente</p>
                            {{ console.log(item.price, item) }}
                        <div class="text-gray-700 font-bold text-xl mb-4">{{ item.price ? item.price + " €" : '' }}
                        </div>
                        <button @click="navigateToOrderForm"
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

export default {
    components: {
        NavbarCat,
        Link,
        Head,
    },
    props: {
        item: Array,
        name: String,
        titulo: String,
        deviceType: String,
    },
    setup() {
        const page = usePage();
        const user = page.props.auth.user;
        return {
            user,
        };
    },
    methods: {
        getImgSrc(item) {
            if (this.deviceType === 'Smartphone') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/smartphone/pantalla.webp';
            } else if (this.deviceType === 'Computer') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/pc/pantallaa.jpg';
            } else if (this.deviceType === 'Console') {
                return '/proyectos/2024/juanmaguerrero/tecno/public/images/consola/console.png';
            }
            return 'https://ximg.es/300.png/09f/fff';
        },
        navigateToOrderForm() {
            this.$inertia.get(this.route('order.form', { id: this.item.id }));
        },
    },
};
</script>
