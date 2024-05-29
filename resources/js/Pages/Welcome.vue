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

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Inicio" />
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
            :class="{
                'hidden': !isSidebarOpen,
                'block': isSidebarOpen,
                'fixed': true,
                'inset-y-0': true,
                'w-64': true,
                'bg-gray-800': true,
                'text-white': true,
                'shadow-md': true,
                'lg:block': true
            }">
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
                            Inicio
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('catalogue')"
                            class="block px-4 py-2 text-white dark:text-gray-200 hover:text-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                            Catálogo de Reparaciones
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('contact')"
                            class="block px-4 py-2 text-white dark:text-gray-200 hover:text-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                            Contacto
                        </Link>
                    </li>
                </ul>
            </nav>
        </aside>

        <div
            :class="{
                'lg:ml-64': isSidebarOpen || !isSidebarOpen,
                'flex-1': true,
                'flex': true,
                'flex-col': true,
                'transition-all': true,
                'duration-300': true
            }">
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
                            Perfil
                        </Link>
                    </nav>
                    <nav v-else class="flex justify-end col-span-2 lg:col-span-1">
                        <Link :href="route('login')"
                            class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">Iniciar
                            Sesión
                        </Link>
                        <Link :href="route('register')"
                            class="ml-4 text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                            Registrarse
                        </Link>
                    </nav>
                </header>

                <h1 class="text-center text-black text-4xl justify-center">TecnoInformática Huelva</h1>

                <main class="space-y-16 py-14 container mx-auto lg:grid lg:grid-cols-2 lg:gap-8">
                    <!-- Sección Bienvenido -->
                    <section id="bienvenido"
                        class="rounded-lg bg-white shadow-md p-6 lg:col-span-2 lg:flex lg:items-center lg:space-x-4">
                        <div class="lg:w-1/2">
                            <h2 class="text-3xl mb-4 text-gray-800 dark:text-gray-200">¡Bienvenido!</h2>
                            <p class="text-lg text-gray-600 dark:text-gray-400">Bienvenido a TecnoInformática Huelva,
                                una empresa dedicada al Servicio Técnico de Dispositivos informáticos.</p>
                        </div>
                        <div class="lg:w-1/2 flex justify-center">
                            <ApplicationLogo class="w-24 h-16 fill-current text-gray-500 hidden lg:block" />
                        </div>
                    </section>

                    <!-- Sección Quiénes somos y ¿Cómo trabajamos? -->
                    <section id="quienes-somos-como-trabajamos"
                        class="rounded-lg bg-white shadow-md p-6 lg:col-span-2 lg:flex lg:items-center lg:space-x-4">
                        <section id="quienes-somos" class="lg:w-1/2">
                            <div>
                                <h2 class="text-3xl mb-4 text-gray-800 dark:text-gray-200">¿Quiénes somos?</h2>
                                <p class="text-lg text-gray-600 dark:text-gray-400">Somos un equipo preparado para
                                    cubrir las necesidades que le surjan a tu equipo informático.</p>
                            </div>
                            <div class="flex justify-center mt-2">
                                <img src="images/tic.webp" alt="Imagen de Quiénes somos"
                                    class="w-full lg:w-72 mb-4 h-56 rounded-xl">
                            </div>
                        </section>
                        <div class="hidden lg:block border-l border-gray-300 mx-4"></div>
                        <section id="como-trabajamos" class="lg:w-1/2">
                            <div>
                                <h2 class="text-3xl mb-4 text-gray-800 dark:text-gray-200">¿Cómo trabajamos?</h2>
                                <p class="text-lg text-gray-600 dark:text-gray-400">Trabajamos con las herramientas más
                                    adaptadas y actuales para la reparación de dispositivos. </p>
                            </div>
                            <div class="flex justify-center mt-2">
                                <img src="images/sat.jpg" alt="Imagen de Quiénes somos"
                                    class="w-full lg:w-72 h-56 rounded-xl">
                            </div>
                        </section>
                    </section>

                    <!-- Sección ¿Dónde estamos? -->
                    <section id="donde-estamos"
                        class="rounded-lg bg-white shadow-md p-6 lg:col-span-2 lg:flex lg:items-center lg:space-x-4">
                        <div class="lg:w-1/2">
                            <h2 class="text-3xl text-gray-800 dark:text-gray-200">¿Dónde estamos?</h2>
                            <p class="text-lg text-gray-600 dark:text-gray-400">Estamos ubicados en Huelva, siempre
                                listos para atenderte.</p>
                        </div>
                        <div class="lg:w-1/2 flex justify-center">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d333.7672550707671!2d-6.926262937123415!3d37.263194154073126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd11d12ab2d94e5b%3A0x5779aae886ac0147!2sApp%20Informatica%20Los%20Rosales!5e0!3m2!1sen!2ses!4v1716485325552!5m2!1sen!2ses"
                                width="100%" height="350" class="rounded-md p-4" style="border:0;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </section>

                    <!-- Sección ¿A qué esperas? -->
                    <section id="a-que-esperas" class="rounded-lg bg-white shadow-md p-6 lg:col-span-2">
                        <h2 class="text-3xl mb-4 text-gray-800 dark:text-gray-200">¿A qué esperas?</h2>
                        <p class="text-lg text-gray-600 mb-4 dark:text-gray-400">¿Necesitas una reparación? No dudes en
                            informarte en la página y pedir la reparación del dispositivo <em>online</em></p>
                        <Link :href="route('catalogue')"
                            class="text-lg p-2 justify-center rounded-lg bg-slate-800 text-white">Ir al catálogo de reparaciones</Link>
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
                </ul>
            </div>

            <!-- Enlaces a secciones -->
            <div class="mb-4 lg:mb-0">
                <h3 class="text-lg font-semibold mb-2">Secciones</h3>
                <ul>
                    <li>
                        <Link href="#bienvenido" class="text-gray-300 hover:text-white">Bienvenido</Link>
                    </li>
                    <li>
                        <Link href="#quienes-somos" class="text-gray-300 hover:text-white">Quiénes somos</Link>
                    </li>
                    <li>
                        <Link href="#como-trabajamos" class="text-gray-300 hover:text-white">Cómo trabajamos</Link>
                    </li>
                    <li>
                        <Link href="#donde-estamos" class="text-gray-300 hover:text-white">Dónde estamos</Link>
                    </li>
                    <li>
                        <Link href="#a-que-esperas" class="text-gray-300 hover:text-white">A qué esperas</Link>
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
                        <Link href="#" class="text-gray-300 hover:text-white">Twitter</Link>
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
                <Link :href="route('contact')" class="text-gray-300 hover:text-white">Contáctanos</Link>
            </div>
        </div>
        <!-- Texto de derechos de autor -->
        <div class="text-center mt-8 lg:col-span-3">
            <p class="text-gray-300">© Juanma Guerrero 2024. Todos los derechos reservados.</p>
        </div>
    </footer>
</template>

<style>
*{
    scroll-behavior: smooth;
}
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
