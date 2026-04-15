<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  product: {
    type: Object,
    default: () => ({
      name: '',
      quantity: 1,
      category_id: '',
    }),
  },
  categories: {
    type: Array,
    default: () => [],
  },
  submitLabel: {
    type: String,
    default: 'Save Product',
  },
  submitUrl: {
    type: String,
    required: true,
  },
  method: {
    type: String,
    default: 'post',
  },
});

const form = useForm({
  name: props.product.name ?? '',
  quantity: props.product.quantity ?? 1,
  category_id: props.product.category_id ?? '',
});

const submit = () => {
  if (props.method === 'put') {
    form.put(props.submitUrl);
    return;
  }

  form.post(props.submitUrl);
};
</script>

<template>
  <form @submit.prevent="submit" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <div>
      <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Product Name</label>
      <input
        id="name"
        v-model="form.name"
        type="text"
        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none ring-0 transition focus:border-indigo-500"
        placeholder="Enter product name"
      />
      <p v-if="form.errors.name" class="mt-2 text-sm text-rose-600">{{ form.errors.name }}</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
      <div>
        <label for="quantity" class="mb-2 block text-sm font-medium text-slate-700">Quantity</label>
        <input
          id="quantity"
          v-model="form.quantity"
          type="number"
          min="1"
          class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none ring-0 transition focus:border-indigo-500"
        />
        <p v-if="form.errors.quantity" class="mt-2 text-sm text-rose-600">{{ form.errors.quantity }}</p>
      </div>

      <div>
        <label for="category_id" class="mb-2 block text-sm font-medium text-slate-700">Category</label>
        <select
          id="category_id"
          v-model="form.category_id"
          class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none ring-0 transition focus:border-indigo-500"
        >
          <option value="">Select a category</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
        <p v-if="form.errors.category_id" class="mt-2 text-sm text-rose-600">{{ form.errors.category_id }}</p>
      </div>
    </div>

    <div class="flex items-center justify-end gap-3">
      <button
        type="submit"
        class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
        :disabled="form.processing"
      >
        {{ form.processing ? 'Saving...' : submitLabel }}
      </button>
    </div>
  </form>
</template>
