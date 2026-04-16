<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  product: Object,
  categories: Array
});

const form = useForm({
  name: props.product.name,
  price: props.product.price,
  quantity: props.product.quantity,
  category_id: props.product.category_id,
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
  form.transform((data) => ({
    ...data,
    _method: 'put',
  })).post(`/products/${props.product.id}`);
};
</script>

<template>
  <AppLayout>
    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Edit Product</h1>
        <Link href="/products" class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</Link>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Product Name</label>
          <input v-model="form.name" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Price</label>
          <input v-model="form.price" type="number" step="0.01" min="0" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Quantity</label>
          <input v-model="form.quantity" type="number" min="1" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Category</label>
          <select v-model="form.category_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
            <option value="">Select Category</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <div v-if="product.image">
          <label class="mb-2 block text-sm font-medium text-slate-700">Current Cover Image</label>
          <img :src="product.image" alt="Product Image" class="h-32 w-32 rounded-xl object-cover border border-slate-200" />
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Replace Cover Image</label>
          <input type="file" accept="image/*" @change="handleCoverImageChange" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
        </div>

        <div v-if="product.images?.length">
          <label class="mb-2 block text-sm font-medium text-slate-700">Current Gallery Images</label>
          <div class="grid grid-cols-3 gap-3">
            <img
              v-for="image in product.images"
              :key="image.id"
              :src="image.image_path"
              class="h-24 w-full rounded-lg object-cover border border-slate-200"
            />
          </div>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Add More Gallery Images</label>
          <input type="file" multiple accept="image/*" @change="handleGalleryImagesChange" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
        </div>

        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-medium text-white hover:bg-indigo-700">
          Update Product
        </button>
      </form>
    </div>
  </AppLayout>
</template>