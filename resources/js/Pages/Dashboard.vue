<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import Navbar from './Navbar.vue';

const page = usePage();
const user = page.props.auth.user;
</script>

<template>

    <Head title="Dashboard" />
    <div class="min-h-screen flex flex-col">
        <Navbar v-if="user && user.admin" />
        <AuthenticatedLayout>
            <template #header>
                <div class="flex items-center justify-between bg-gray-100 px-6 py-4 border-b">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                    <div class="flex items-center">
                        <span class="ml-3 text-gray-700">Hola, {{ user.name }}!</span>
                    </div>
                </div>
            </template>

            <div class="flex flex-1 px-6 py-4">

                <main class="flex-1 p-8 bg-gray-100">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Bienvenido de nuevo, {{ user.name }}!
                            </h3>
                            <p class="text-gray-700">Aquí puedes ver el estado de tu cuenta y realizar acciones
                                administrativas.</p>
                        </div>
                    </div>
                </main>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<style scoped>
/* Custom styles if needed */
</style>
