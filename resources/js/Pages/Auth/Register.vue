<template>
  <GuestLayout>
      <Head title="Registro" />

      <form @submit.prevent="submit">
          <div>
              <InputLabel for="name" value="Nombre" />

              <TextInput
                  id="name"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.name"
                  required
                  autofocus
                  autocomplete="name"
              />

              <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <div class="mt-4">
              <InputLabel for="email" value="Email" />

              <TextInput
                  id="email"
                  type="email"
                  class="mt-1 block w-full"
                  v-model="form.email"
                  required
                  autocomplete="username"
              />

              <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="mt-4">
              <InputLabel for="password" value="Contraseña" />

              <TextInput
                  id="password"
                  type="password"
                  class="mt-1 block w-full"
                  v-model="form.password"
                  required
                  autocomplete="new-password"
              />

              <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="mt-4">
              <InputLabel for="password_confirmation" value="Confirmar Contraseña" />

              <TextInput
                  id="password_confirmation"
                  type="password"
                  class="mt-1 block w-full"
                  v-model="form.password_confirmation"
                  required
                  autocomplete="new-password"
              />

              <InputError class="mt-2" :message="form.errors.password_confirmation" />
          </div>

          <!-- Phone Field -->
          <div class="mt-4">
            <InputLabel for="phone" value="Teléfono" />

            <TextInput
                id="phone"
                type="number"
                max="999999999"
                class="mt-1 block w-full"
                v-model="form.phone"
                required
                autocomplete="phone"
            />

            <InputError class="mt-2" :message="form.errors.phone" />
        </div>

          <!-- City Field -->
          <div class="mt-4">
              <InputLabel for="city" value="Ciudad" />

              <TextInput
                  id="city"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.city"
                  required
                  autocomplete="city"
              />

              <InputError class="mt-2" :message="form.errors.city" />
          </div>

          <!-- Address Field -->
          <div class="mt-4">
              <InputLabel for="adress" value="Dirección" />

              <TextInput
                  id="adress"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.adress"
                  required
                  autocomplete="adress"
              />

              <InputError class="mt-2" :message="form.errors.adress" />
          </div>

          <!-- Zip Code Field -->
          <div class="mt-4">
              <InputLabel for="zip_code" value="Código Postal" />

              <TextInput
                  id="zip_code"
                  type="number"
                  max="99999"
                  class="mt-1 block w-full"
                  v-model="form.zip_code"
                  required
                  autocomplete="zip_code"
              />

              <InputError class="mt-2" :message="form.errors.zip_code" />
          </div>

          <div class="flex items-center justify-end mt-4">
              <Link
                  :href="route('login')"
                  class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                  Ya tienes cuenta?
              </Link>

              <PrimaryButton class="w-auto ml-4 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :class="{ 'opacity-25': form.processing } " :disabled="form.processing">
                  Registrar
              </PrimaryButton>
          </div>
      </form>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  city: '',
  adress: '',
  zip_code: '',
});

const submit = () => {
  form.post(route('register'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>
