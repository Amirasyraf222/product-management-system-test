<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
  products: Object,
  categories: Array,
  filters: Object,
});

const applyFilters = (event) => {
  const form = new FormData(event.target.form ?? event.target.closest('form'));

  router.get('/products', Object.fromEntries(form.entries()), {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
};

const toggleSort = (field) => {
  const direction =
    props.filters.sort_by === field && props.filters.direction === 'asc'
      ? 'desc'
      : 'asc';

  router.get(
    '/products',
    {
      category_id: props.filters.category_id,
      sort_by: field,
      direction,
    },
    {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    }
  );
};
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
          <h2 class="text-2xl font-bold text-slate-900">Products</h2>
          <p class="text-sm text-slate-500">
            Manage all products and their categories in one place.
          </p>
        </div>
      </div>

      <form
        class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-3"
      >
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700"
            >Filter by Category</label
          >
          <select
            name="category_id"
            :value="filters.category_id"
            @change="applyFilters"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"
          >
            <option value="">All Categories</option>
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700"
            >Sort By</label
          >
          <select
            name="sort_by"
            :value="filters.sort_by"
            @change="applyFilters"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"
          >
            <option value="name">Name</option>
            <option value="quantity">Quantity</option>
          </select>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700"
            >Direction</label
          >
          <select
            name="direction"
            :value="filters.direction"
            @change="applyFilters"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"
          >
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
          </select>
        </div>
      </form>

      <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div
          v-if="products.data.length === 0"
          class="px-6 py-12 text-center"
        >
          <h3 class="text-lg font-semibold text-slate-900">
            No products found
          </h3>
          <p class="mt-2 text-sm text-slate-500">
            Try changing the filter, or add your first product.
          </p>
          <Link
            href="/products/create"
            class="mt-4 inline-flex rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
          >
            Create Product
          </Link>
        </div>

        <table v-else class="min-w-full divide-y divide-slate-200">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                Image
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                <button @click="toggleSort('name')" type="button">
                  Name
                </button>
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Price</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500">
                Category
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500">
                <button @click="toggleSort('quantity')" type="button">
                  Quantity
                </button>
              </th>
              <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-slate-500">
                Action
              </th>
            </tr>
          </thead>

         <tbody class="divide-y divide-slate-100 bg-white">
          <tr v-for="product in products.data" :key="product.id" class="hover:bg-slate-50">
            <td class="px-6 py-4">
              <img
                v-if="product.image"
                :src="product.image"
                class="h-14 w-14 rounded-lg object-cover border"
              />
              <div
                v-else
                class="flex h-14 w-14 items-center justify-center rounded-lg border bg-slate-100 text-xs text-slate-400"
              >
                No Image
              </div>
            </td>

            <td class="px-6 py-4 text-sm font-medium text-slate-900">
              {{ product.name }}
            </td>

            <td class="px-6 py-4 text-sm text-slate-600">
              RM{{ Number(product.price).toFixed(2) }}
            </td>

            <td class="px-6 py-4 text-sm text-slate-600">
              {{ product.category }}
            </td>

            <td class="px-6 py-4 text-sm text-slate-600">
              {{ product.quantity }}
            </td>

            <td class="px-6 py-4 text-right">
              <Link
                :href="`/products/${product.id}/edit`"
                class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
              >
                Edit
              </Link>
            </td>
          </tr>
        </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>