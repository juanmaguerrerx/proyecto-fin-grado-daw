<template>
    <nav class="bg-gray-800 text-white p-4 fixed top-0 w-full z-10">
      <div class="container mx-auto flex justify-between items-center">
        <!-- Logo y Links -->
        <div class="flex items-center space-x-4">
          <AplicationLogo class="h-8 w-12 md:h-10 md:w-14" />
          <button @click="toggleMobileMenu" class="md:hidden focus:outline-none">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-gray-300 hover:text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"
              ></path>
            </svg>
          </button>
          <ul class="hidden md:flex space-x-4">
            <li>
              <Link :href="route('index')" class="text-gray-300 hover:text-white">Inicio</Link>
            </li>
            <li>
              <Link :href="route('device.indexUser')" class="text-gray-300 hover:text-white">Dispositivos</Link>
            </li>
            <li>
              <Link :href="route('models.indexUser')" class="text-gray-300 hover:text-white">Modelos</Link>
            </li>
            <li>
              <Link :href="route('catalogue')" class="text-gray-300 hover:text-white">Todo</Link>
            </li>
          </ul>
        </div>
        <!-- Icono de Perfil -->
        <div v-if="user" class="relative">
          <button @click="toggleDropdown" class="flex items-center focus:outline-none">
            <i class="fa-solid fa-user text-white"></i>
          </button>
          <div v-if="isDropdownOpen" @click="toggleDropdown" class="fixed inset-0 h-full w-full z-10"></div>
          <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20">
            <Link :href="route('profile.edit')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Perfil</Link>
            <Link :href="route('logout')" method="post" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
              Cerrar Sesión
            </Link>
          </div>
        </div>
        <div v-else relative>
            <Link :href="route('login')" class="text-gray-300 hover:text-white">Iniciar Sesión</Link>
            <Link :href="route('register')" class="text-gray-300 hover:text-white ml-4">Regístrate</Link>
        </div>
      </div>
      <!-- Menú Móvil -->
      <div v-show="showMobileMenu" class="md:hidden fixed top-0 left-0 w-full h-full bg-gray-800 z-20">
        <div class="flex flex-col items-center justify-center h-full space-y-4 text-center">
          <Link :href="route('index')" @click="toggleMobileMenu" class="text-white text-lg">Inicio</Link>
          <Link :href="route('device.indexUser')" @click="toggleMobileMenu" class="text-white text-lg">Dispositivos</Link>
          <Link :href="route('models.indexUser')" @click="toggleMobileMenu" class="text-white text-lg">Modelos</Link>
          <Link :href="route('catalogue')" @click="toggleMobileMenu" class="text-white text-lg">Todo</Link>
          <div class="space-y-4 mt-4">
            <div v-if="user" class="text-center">
              &nbsp;&nbsp;<Link :href="route('profile.edit')" @click="toggleMobileMenu" class="text-white ml-10 text-lg">Perfil</Link> &nbsp;&nbsp; | &nbsp;&nbsp;
              <Link :href="route('logout')" method="post" as="button" @click="toggleMobileMenu" class="text-white text-lg">
                Cerrar Sesión
              </Link>
            </div>
            <div v-else class="text-center">
              <Link :href="route('login')" @click="toggleMobileMenu" class="text-white text-lg">Iniciar Sesión</Link>
              <Link :href="route('register')" @click="toggleMobileMenu" class="text-white text-lg">Regístrate</Link>
            </div>
          </div>
        </div>
        <button @click="toggleMobileMenu" class="absolute top-4 right-4 focus:outline-none">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 text-white"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </nav>
  </template>
  
  <script>
  import { Link, usePage } from '@inertiajs/vue3';
  import AplicationLogo from './../Components/ApplicationLogo.vue';
  import Dropdown from './../Components/Dropdown.vue'; // Importamos el componente Dropdown
  
  export default {
    components: {
      Link,
      AplicationLogo,
      Dropdown, // Agregamos el componente Dropdown
    },
    data() {
      return {
        isDropdownOpen: false,
        showMobileMenu: false,
      };
    },
    setup() {
      const page = usePage();
      const user = page.props.auth.user;
  
      return {
        user,
      };
    },
    methods: {
      toggleDropdown() {
        this.isDropdownOpen = !this.isDropdownOpen;
      },
      toggleMobileMenu() {
        this.showMobileMenu = !this.showMobileMenu;
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos adicionales si son necesarios */
  </style>
  