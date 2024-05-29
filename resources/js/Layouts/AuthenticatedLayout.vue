<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Navbar from '@/Pages/Navbar.vue';
import NavLink from '@/Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav v-if="!user.admin"class="bg-white border-b border-gray-100 shadow-md fixed top-0 w-full z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                <Link :href="route('index')" class="flex items-center">
                                <ApplicationLogo class="block h-8 w-auto fill-current text-gray-800" />
                                <span class="ml-2 font-semibold text-xl text-gray-800">TecnoInformática Huelva</span>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('index')" :active="route().current('index')">
                                    Inicio
                                </NavLink>
                            </div>
                            <div class="hidden sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                                    Perfil
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- User Dropdown -->
                            <div class="relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button
                                            class="flex items-center text-sm font-medium text-gray-500 rounded-md focus:outline-none focus:text-gray-700">
                                            <div v-if="user && user.name"
                                                class="w-8 h-8 rounded-full bg-gray-500 flex items-center justify-center text-white">
                                                <span>{{ user.name.charAt(0).toUpperCase() }}</span>
                                            </div>
                                            <span class="ml-2">{{ user ? user.name : '' }}</span>
                                        </button>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">Perfil</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">Cerrar Sesión
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                            <div class="ml-4">
                                <Link :href="route('logout')" method="post" as="button"><i class="fa-solid fa-right-from-bracket text-xl"></i></Link>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md focus:outline-none focus:text-gray-500">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                    <path
                                        :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('index')" :active="route().current('index')">Inicio
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                            Perfil
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ user ? user.name : '' }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ user ? user.email : '' }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">Perfil</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">Cerrar Sesión
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>
            <Navbar v-else/>
            <!-- Page Content -->
            <main class="mt-14">
                <slot />
            </main>
        </div>
    </div>
</template>
