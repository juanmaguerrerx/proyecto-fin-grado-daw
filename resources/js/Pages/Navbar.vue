<template>
    <nav class="fixed top-0 z-10 left-0 w-full bg-white shadow-md py-4 px-8 flex items-center justify-between">
        <!-- Botón de menú (mostrar en dispositivos móviles) -->
        <div class="md:hidden">
            <button @click="toggleMobileMenu" class="focus:outline-none">
                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Logo y links -->
        <div class="flex items-center space-x-4">
            <!-- Lista de links -->
            <ul class="hidden md:flex space-x-4 text-lg">
                <li class="ml-4">
                    <Link :href="route('models.index')" class="hover:text-gray-600">Modelos</Link>
                </li>
                <li class="ml-4">
                    <Link :href="route('device.index')" class="hover:text-gray-600">Dispositivos</Link>
                </li>
                <li class="ml-4">
                    <Link :href="route('order.index')" class="hover:text-gray-600">Órdenes</Link>
                </li>
                <li class="ml-4">
                    <Link :href="route('reparation.index')" class="hover:text-gray-600">Reparaciones</Link>
                </li>
                <li class="ml-4">
                    <Link :href="route('user.index')" class="hover:text-gray-600">Usuarios</Link>
                </li>
            </ul>
        </div>

        <!-- Botón Dashboard -->
        <div>
            <Link :href="route('profile.edit')" class="text-lg hover:text-gray-600"><i class="fa-solid fa-user"></i></Link>
            <Link :href="route('logout')" method="post" as="button"><i class="fa-solid fa-right-from-bracket ml-4 text-xl"></i></Link>
        </div>

        <!-- Menú móvil -->
        <div v-show="showMobileMenu"
            class="md:hidden z-10 fixed top-0 left-0 w-full h-full bg-white z-10 overflow-auto">
            <div class="flex items-center justify-center h-full">
                <ul class="text-lg text-center">
                    <li class="my-4">
                        <Link :href="route('models.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">Modelos</Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('device.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">Dispositivos
                        </Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('order.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">Órdenes</Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('reparation.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">Reparaciones
                        </Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('user.index')" @click="toggleMobileMenu" class="hover:text-gray-600 block">Usuarios
                        </Link>
                    </li>
                    <li class="my-4">
                        <Link :href="route('profile.edit')" @click="toggleMobileMenu" class="hover:text-gray-600 block">Perfil
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
    </nav>
</template>

<script>
import { Link } from '@inertiajs/vue3'; // Importa específicamente el componente Link de inertia-vue3

export default {
    data() {
        return {
            showMobileMenu: false // Variable para controlar el estado del menú móvil
        };
    },
    components: {
        Link // Registra el componente Link
    },
    methods: {
        toggleMobileMenu() {
            this.showMobileMenu = !this.showMobileMenu; // Cambia el estado del menú móvil
        }
    }
}
</script>