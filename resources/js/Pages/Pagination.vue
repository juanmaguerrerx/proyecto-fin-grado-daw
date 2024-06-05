<template>
    <div class="flex flex-col md:flex-row justify-between items-center mt-4 space-y-2 md:space-y-0 md:space-x-4">
        <div class="flex items-center space-x-2">
            <label for="perPage" class="text-sm">Elementos por página:</label>
            <select id="perPage" v-model="itemsPerPage" @change="updateItemsPerPage" class="rounded-md">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="75">75</option>
            </select>
        </div>
        <div class="flex items-center space-x-2">
            <button @click="goToPage(1)" :disabled="currentPage === 1"
                class="rounded-md px-3 py-1 bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">Primera</button>
            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
                class="rounded-md px-3 py-1 bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">Anterior</button>
            <span class="text-sm">{{ currentPage }} de {{ totalPages }}</span>
            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages"
                class="rounded-md px-3 py-1 bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">Siguiente</button>
            <button @click="goToPage(totalPages)" :disabled="currentPage === totalPages"
                class="rounded-md px-3 py-1 bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">Última</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        totalPages: {
            type: Number,
            required: true,
        },
        perPage: {
            type: Number,
            required: true,
        }
    },
    data() {
        return {
            itemsPerPage: this.perPage,
        };
    },
    methods: {
        updateItemsPerPage() {
            this.$emit('update-items-per-page', parseInt(this.itemsPerPage));
        },
        goToPage(page) {
            this.$emit('update-current-page', page);
        },
    },
};
</script>

<style scoped>
@media (max-width: 768px) {
    .space-x-4 {
        justify-content: center;
    }
}
</style>
