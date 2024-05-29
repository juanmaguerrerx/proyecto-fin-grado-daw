<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container mt-4 overflow-hidden shadow-lg mx-auto w-full">
          <div class="modal-header">
            <slot name="header">
              Default Header
            </slot>
            <button @click="$emit('close')" class="modal-close">
              <i class="fa-regular fa-circle-xmark text-xl text-red-500"></i>
            </button>
          </div>
          <div class="modal-body">
            <!-- Botón para activar la edición -->
            <button @click="toggleEdit" v-if="!editing"
              class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              Editar
            </button>
            <button @click="confirmDelete"
              class="mr-4 ml-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
              Eliminar
            </button>
            <slot name="body">
              <!-- Renderizar formulario dinámico -->
              <form @submit.prevent="emitSaveChanges" method="POST">
                <!-- Campo oculto para el método PUT -->
                <input type="hidden" name="_method" value="PUT">

                <div v-if="titulo !== 'Usuarios'" v-for="(value, key) in data" :key="key" class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2">{{ key }}</label>
                  <!-- Agregar la directiva :disabled basado en si el campo es "id" o no -->
                  <input v-if="titulo != 'Usuarios'" v-model="data[key]" :disabled="shouldDisableField(key)"
                    class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <div v-else
                    class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    {{ data[key] }}</div>
                </div>


                <div class="modal-footer" v-if="editing">
                  <button type="submit"
                    class="mr-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Guardar
                  </button>
                  <button @click="cancelEdit"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancelar
                  </button>
                </div>
              </form>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'Modal',
  props: {
    data: Object, // Objeto con los datos a mostrar
    disableFields: Boolean, // Indica si los campos deben estar deshabilitados o no
    tableName: String
  },
  data() {
    return {
      editing: false // Indica si se está editando el objeto
    };
  },
  methods: {
    toggleEdit() {
      this.editing = true; // Cambiar el estado de edición a verdadero
    },
    cancelEdit() {
      this.editing = false; // Cancelar la edición
    },
    confirmDelete() {
      if (confirm('¿Estás seguro de que deseas eliminar este elemento?')) {
        // Emitir evento para confirmar la eliminación
        this.$emit('delete');
      }
    },
    emitSaveChanges() {
      this.$emit('save', this.data);
      this.editing = false; // Cambiar el estado de edición a falso
    },
    shouldDisableField(key) {
      // Deshabilita el campo "id" siempre y otros campos cuando no estás en modo de edición y disableFields está activo
      return (key === 'id' || this.disableFields) && !this.editing;
    }
  }
}
</script>


<style scoped>
/* Estilos del modal */
.modal-mask {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  /* Elimina la regla de centrado */
  display: flex;
  /* Añade esta propiedad para permitir el desplazamiento vertical */
  overflow-y: auto;
}

.modal-wrapper {
  width: 100%;
}

.modal-container {
  background: #fff;
  border-radius: 4px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  padding: 20px;
  /* Agrega una regla de ancho máximo si lo consideras necesario */
  max-width: 800px;
  /* Ejemplo de ancho máximo */
  /* Añade esta propiedad para centrar el contenido horizontalmente */
  justify-content: center;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.modal-close {
  background: none;
  border: none;
  cursor: pointer;
}

.modal-body {
  margin-top: 20px;
  margin-bottom: 10px;
}

.modal-footer {
  margin-top: 20px;
  display: flex;
  justify-content: flex-end;
}
</style>
