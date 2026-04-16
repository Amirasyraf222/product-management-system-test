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
});

const handleImageChange = (event) => {
  form.image = event.target.files[0];
};

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      _method: 'put',
    }))
    .post(`/products/${props.product.id}`);
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
          <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</p>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Price (RM)</label>
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

        <div v-if="product.image">
          <label class="mb-2 block text-sm font-medium text-slate-700">Current Image</label>
          <img :src="product.image" alt="Product Image" class="h-40 w-40 rounded-xl object-cover border border-slate-200" />
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Replace Image</label>
          <input type="file" accept="image/*" @change="handleImageChange" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" />
          <p v-if="form.errors.image" class="mt-1 text-sm text-red-500">{{ form.errors.image }}</p>
        </div>

        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-medium text-white hover:bg-indigo-700" :disabled="form.processing">
          Update Product
        </button>
      </form>
    </div>
  </AppLayout>
</template>