<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
  categories: Array
});

const form = useForm({
  name: '',
  price: '',
  quantity: 1,
  category_id: '',
  image: null,
  images: [],
});

const handleCoverImageChange = (event) => {
  form.image = event.target.files[0];
};

const handleGalleryImagesChange = (event) => {
  form.images = Array.from(event.target.files);
};

const submit = () => {
  form.post('/products');
};
</script>

<template>
  <AppLayout>
    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Create Product</h1>
        <Link href="/products" class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</Link>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Product Name</label>
          <input v-model="form.name" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
          <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</p>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Price</label>
          <input v-model="form.price" type="number" step="0.01" min="0" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
          <p v-if="form.errors.price" class="mt-1 text-sm text-red-500">{{ form.errors.price }}</p>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Quantity</label>
          <input v-model="form.quantity" type="number" min="1" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
          <p v-if="form.errors.quantity" class="mt-1 text-sm text-red-500">{{ form.errors.quantity }}</p>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Category</label>
          <select v-model="form.category_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
            <option value="">Select Category</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
          <p v-if="form.errors.category_id" class="mt-1 text-sm text-red-500">{{ form.errors.category_id }}</p>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Cover Image</label>
          <input type="file" accept="image/*" @change="handleCoverImageChange" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
          <p v-if="form.errors.image" class="mt-1 text-sm text-red-500">{{ form.errors.image }}</p>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Gallery Images</label>
          <input type="file" multiple accept="image/*" @change="handleGalleryImagesChange" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
          <p v-if="form.errors['images.0']" class="mt-1 text-sm text-red-500">{{ form.errors['images.0'] }}</p>
        </div>

        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-medium text-white hover:bg-indigo-700" :disabled="form.processing">
          Save Product
        </button>
      </form>
    </div>
  </AppLayout>
</template>