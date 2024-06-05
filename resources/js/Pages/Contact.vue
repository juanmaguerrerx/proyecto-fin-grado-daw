<script setup>
import { ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const isSidebarOpen = ref(false);

const page = usePage();
const user = page.props.auth.user;

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

<template>
    <Head title="Contáctanos" />
    <div class="flex min-h-screen bg-gray-100 text-black/50 dark:bg-black dark:text-white/50">
        <!-- Botón para abrir el menú lateral en pantallas pequeñas -->
        <button @click="toggleSidebar"
            class="p-2 m-2 lg:hidden focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 fixed top-2 left-2 z-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 dark:text-gray-200" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>

        <!-- Menú lateral -->
        <aside
            :class="{ 'hidden': !isSidebarOpen, 'block': isSidebarOpen, 'fixed': true, 'inset-y-0': true, 'w-64': true, 'bg-gray-800': true, 'text-white': true, 'shadow-md': true, 'lg:block': true }">
            <button @click="toggleSidebar"
                class="p-2 m-2 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 lg:hidden fixed top-2 right-2 z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white dark:text-gray-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="p-4">
                <ApplicationLogo class="w-24 h-16 fill-current text-white mx-auto" />
            </div>
            <nav class="mt-6">
                <ul>
                    <li>
                        <Link :href="route('index')"
                            class="block px-4 py-2 text-white dark:text-gray-200 hover:text-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                        Inicio</Link>
                    </li>
                    <li>
                        <Link :href="route('catalogue')"
                            class="block px-4 py-2 text-white dark:text-gray-200 hover:text-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                        Catálogo de Reparaciones</Link>
                    </li>
                    <li>
                        <Link :href="route('contact')"
                            class="block px-4 py-2 text-white dark:text-gray-200 hover:text-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                        Contacto</Link>
                    </li>
                    <li v-if="orders.length != 0">
                        <Link :href="route('ordersIndex')"
                            class="block px-4 py-2 text-white dark:text-gray-200 hover:text-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                        Órdenes</Link>
                    </li>
                </ul>
            </nav>
        </aside>

        <div
            :class="{ 'ml-64': isSidebarOpen || !isSidebarOpen, 'flex-1': true, 'flex': true, 'flex-col': true, 'items-center': true, 'justify-center': true, 'transition-all': true, 'duration-300': true }">
            <div class="w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <ApplicationLogo class="w-24 h-16 fill-current text-gray-500 hidden lg:block" />
                    </div>

                    <!-- Enlaces de navegación -->
                    <nav v-if="user" class="flex justify-end col-span-2 lg:col-span-1">
                        <Link :href="route('dashboard')"
                            class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">Dashboard
                        </Link>
                        <Link :href="route('profile.edit')"
                            class="ml-4 text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                        Perfil</Link>
                    </nav>
                    <nav v-else class="flex justify-end col-span-2 lg:col-span-1">

                        <Link :href="route('login')"
                            class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">Iniciar
                        Sesión</Link>
                        <Link :href="route('register')"
                            class="ml-4 text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                        Registrarse</Link>
                    </nav>
                </header>

                <main class="space-y-16 py-14 container mx-auto lg:grid lg:grid-cols-1 lg:gap-8">
                    <!-- Sección de contacto -->
                    <section id="contacto" class="rounded-lg bg-white shadow-md p-6 lg:col-span-2">
                        <h2 class="text-3xl mb-4 text-gray-800 dark:text-gray-200">Contáctanos</h2>
                        <div class="text-lg text-gray-600 dark:text-gray-400">
                            <p class="mb-4"><strong>Dirección:</strong> Av. de las Fuerzas Armadas, 8, 21007 Huelva</p>
                            <p class="mb-4"><strong>Correo Electrónico:</strong> tecnoinformaticahuelva@gmail.com</p>
                            <p class="mb-4"><strong>Teléfono:</strong>  <a href="tel:959822715" class="text-blue-500 hover:underline">959 82 27 15</a> | <a href="tel:+34601417981" class="text-blue-500 hover:underline">+34 601 41 79 81</a></p>
                            <p class="mb-4"><strong>Nombre de contacto:</strong> Juanma Guerrero</p>
                            <p class="mb-4"><strong>Horario de la tienda:</strong> Lunes a Jueves, 10:00 - 14:30 y 17:00 - 20:30 <br>Viernes, 10:00 - 14:30</p>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 ml-64">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-5 gap-4 px-6">
            <!-- Enlaces de navegación -->
            <div class="mb-4 lg:mb-0">
                <h3 class="text-lg font-semibold mb-2">Navegación</h3>
                <ul>
                    <li>
                        <Link :href="route('index')" class="text-gray-300 hover:text-white">Inicio</Link>
                    </li>
                    <li>
                        <Link :href="route('catalogue')" class="text-gray-300 hover:text-white">Catálogo de Reparaciones</Link>
                    </li>
                    <li>
                        <Link :href="route('contact')" class="text-gray-300 hover:text-white">Contacto</Link>
                    </li>
                    <li v-if="orders.length != 0">
                        <Link :href="route('ordersIndex')" class="text-gray-300 hover:text-white">Órdenes</Link>
                    </li>
                </ul>
            </div>

            <!-- Enlaces a redes sociales -->
            <div class="mb-4 lg:mb-0">
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
                </ul>
            </div>

            <!-- Enlace a GitHub -->
            <div class="mb-4 lg:mb-0">
                <h3 class="text-lg font-semibold mb-2">GitHub</h3>
                <a href="https://github.com/juanmaguerrerx" target="_blank" class="text-gray-300 hover:text-white">Repositorio en GitHub</a>
            </div>

            <!-- Enlace a la pestaña de contacto -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Contacto</h3>
                <Link href="#" class="text-gray-300 hover:text-white">Contáctanos</Link>
            </div>
        </div>
        <!-- Texto de derechos de autor -->
        <div class="text-center mt-8 lg:col-span-3">
            <p class="text-gray-300">© Juanma Guerrero 2024. Todos los derechos reservados.</p>
        </div>
    </footer>
</template>

<style>
/* Asegura que el contenido principal respete el espacio del aside en pantallas pequeñas */
@media (max-width: 1024px) {
    .ml-64 {
        margin-left: 0;
    }
}

/* Ocultar logo en el contenido principal cuando el aside está escondido */
@media (max-width: 1024px) {
    header .hidden {
        display: none !important;
    }
}
</style>
