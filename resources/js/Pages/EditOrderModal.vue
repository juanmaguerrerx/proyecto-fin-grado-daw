<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" v-if="show">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-lg">
                <h2 class="text-2xl mb-4">Editar Orden</h2>
                <form @submit.prevent="updateOrder">
                    <!-- Select Estado -->
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700">Estado</label>
                        <select v-model="form.status" id="status" class="w-full p-2 border rounded">
                            <option v-for="status in statuses" :key="status" :value="status">{{ status }}</option>
                        </select>
                    </div>
                    <!-- Fecha de entrada -->
                    <div class="mb-4">
                        <label for="order_date" class="block text-gray-700">Fecha de entrada</label>
                        <input type="date" v-model="form.order_date" id="order_date" class="w-full p-2 border rounded">
                    </div>
                    <!-- Fecha de reparación -->
                    <div class="mb-4">
                        <label for="reparation_date" class="block text-gray-700">Fecha de reparación</label>
                        <input type="date" v-model="form.reparation_date" id="reparation_date" class="w-full p-2 border rounded">
                    </div>
                    <!-- Select Reparación con búsqueda -->
                    <div class="mb-4">
                        <label for="reparation" class="block text-gray-700">Reparación</label>
                        <input type="text" v-model="reparationSearch" placeholder="Buscar..." class="w-full p-2 border rounded mb-2">
                        <select v-model="form.reparation_id" id="reparation" class="w-full p-2 border rounded">
                            <option v-for="reparation in filteredReparations" :key="reparation.id" :value="reparation.id">
                                {{ reparation.type }} {{ reparation.model }} {{ reparation.device }}
                            </option>
                        </select>
                    </div>
                    <!-- Botones -->
                    <div class="flex justify-end">
                        <button type="button" @click="closeModal" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: Boolean,
        order: Object,
        reparations: Array,
        statuses: Array
    },
    data() {
        return {
            form: {
                status: this.order.status,
                order_date: this.order.order_date,
                reparation_date: this.order.reparation_date,
                reparation_id: this.order.reparation_info.id,
            },
            reparationSearch: ''
        };
    },
    computed: {
        filteredReparations() {
            const search = this.reparationSearch.toLowerCase();
            return this.reparations.filter(reparation => 
                reparation.type.toLowerCase().includes(search) ||
                reparation.model.toLowerCase().includes(search) ||
                reparation.device.toLowerCase().includes(search)
            );
        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        updateOrder() {
            this.$emit('update', { ...this.form });
        }
    }
};
</script>

<style scoped>
/* Añade estilos adicionales si es necesario */
</style>
