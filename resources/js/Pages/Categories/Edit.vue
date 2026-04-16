<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
  category: Object,
});

const form = useForm({
  name: props.category.name,
});

const submit = () => {
  form.put(`/categories/${props.category.id}`);
};
</script>

<template>
  <AppLayout>
    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Edit Category</h1>
        <Link href="/categories" class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">
          Back
        </Link>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Category Name</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"
          />
          <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">
            {{ form.errors.name }}
          </p>
        </div>

        <button
          type="submit"
          class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-medium text-white hover:bg-indigo-700"
          :disabled="form.processing"
        >
          Update Category
        </button>
      </form>
    </div>
  </AppLayout>
</template>