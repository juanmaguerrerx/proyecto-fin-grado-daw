<template>
  <form @submit.prevent="handleSubmit" class="ml-2">
    <div v-for="(field, index) in fields" :key="index" class="mb-4">
      <label v-if="field !== 'model' && field !== 'id'" :for="field" class="block text-gray-700 font-bold mb-2">{{ field }}</label>
      
      <input v-if="field === 'model_id' || field === 'device_id'" type="text" v-model="searchQuery" :list="field + 'List'" placeholder="Buscar..." class="border rounded w-fit mr-2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2">
      
      <select v-if="field === 'model_id'" v-model="formData[field]" :disabled="isDisabled(field)" class="border rounded w-fit mr-2 py-2 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <option value="" disabled selected>Selecciona un modelo</option>
        <option v-for="model in filteredModels" :key="model.id" :value="model.id">{{ model.name }}</option>
      </select>
      
      <select v-if="field === 'device_id'" v-model="formData[field]" :disabled="isDisabled(field)" class="border rounded w-fit mr-2 py-2 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <option value="" disabled selected>Selecciona un dispositivo</option>
        <option v-for="device in filteredDevices" :key="device.id" :value="device.id">{{ device.modelName }}</option>
      </select>

      <!-- Si no es 'model_id', 'model', o 'id', muestra un input de texto -->
      <input v-else-if="field !== 'model' && field !== 'id'" v-model="formData[field]" :id="field" :type="field.type || 'text'" :disabled="isDisabled(field)" class="border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <button type="submit" class="bg-blue-500 mb-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
      Añadir
    </button>
  </form>
</template>

<script>
export default {
  props: {
    fields: Array, // Array de campos para el formulario
    models: Array, // Array de modelos disponibles
    devices: Array,
  },
  data() {
    return {
      formData: {}, // Objeto para almacenar los datos del formulario
      searchQuery: '', // Consulta de búsqueda
    };
  },
  computed: {
    // Filtra los modelos basados en la consulta de búsqueda
    filteredModels() {
      return this.models.filter(model =>
        model.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    // Filtra los dispositivos basados en la consulta de búsqueda
    filteredDevices() {
      return this.devices.filter(device =>
        device.modelName.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    }
  },
  methods: {
    isDisabled(key) {
      // Lógica para deshabilitar campos si es necesario
      // Puedes implementar tu lógica aquí según tus necesidades
    },
    handleSubmit() {
      this.$emit('form-submit', this.formData);
    }
  }
};
</script>

<style scoped>
/* Estilos opcionales para mejorar la apariencia del campo de búsqueda */
input[type="text"] {
  transition: border-color 0.2s ease-in-out;
}

input[type="text"]:focus {
  border-color: #4d90fe;
}
</style>
