<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
import Swal from 'sweetalert2';
import { ref, computed } from 'vue';

const showGallery = ref(false);
const selectedProduct = ref(null);
const activeImageIndex = ref(0);

const openGallery = (product, index = 0) => {
  const allImages = [];

  if (product.image) {
    allImages.push(product.image);
  }

  if (product.images?.length) {
    product.images.forEach((img) => {
      if (!allImages.includes(img)) {
        allImages.push(img);
      }
    });
  }

  selectedProduct.value = {
    ...product,
    allImages,
  };

  activeImageIndex.value = index;
  showGallery.value = true;
};

const closeGallery = () => {
  showGallery.value = false;
  selectedProduct.value = null;
  activeImageIndex.value = 0;
};

const nextImage = () => {
  if (!selectedProduct.value?.allImages?.length) return;
  activeImageIndex.value =
    (activeImageIndex.value + 1) % selectedProduct.value.allImages.length;
};

const prevImage = () => {
  if (!selectedProduct.value?.allImages?.length) return;
  activeImageIndex.value =
    (activeImageIndex.value - 1 + selectedProduct.value.allImages.length) %
    selectedProduct.value.allImages.length;
};

const currentImage = computed(() => {
  if (!selectedProduct.value?.allImages?.length) return null;
  return selectedProduct.value.allImages[activeImageIndex.value];
});

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

const resetFilters = () => {
  router.get('/products', {}, {
    preserveState: false,
    preserveScroll: true,
  });
};

const deleteProduct = (id) => {
  Swal.fire({
    title: 'Delete Product?',
    text: "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444', // red
    cancelButtonColor: '#64748b',  // gray
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/products/${id}`, {
        preserveScroll: true,
        onSuccess: () => {
          Swal.fire({
            title: 'Deleted!',
            text: 'Product has been deleted.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
          });
        }
      });
    }
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
      per_page: props.filters.per_page ?? 5,
    },
    {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    }
  );
};

const goToPage = (url) => {
  if (!url) return;

  router.get(url, {}, {
    preserveState: true,
    preserveScroll: true,
  });
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
                <nav class="flex items-center gap-3">
          <Link
            href="/products/create"
            class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
          >
            Add Product
          </Link>
           <Link href="/preview" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm text-white hover:bg-emerald-700">
          Preview Carousell
        </Link>
        </nav>
      </div>

      <form
          class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-4 items-end"      >
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
            <option value="price">Price</option>
          </select>
        </div>
        
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">
            Show Per Page
          </label>
          <select
            name="per_page"
            :value="filters.per_page ?? 5"
            @change="applyFilters"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"
          >
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
          </select>
        </div>

        <div class="flex">
          <button
            type="button"
            @click="resetFilters"
            class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
          >
            Reset
          </button>
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

        <template v-else>
          <table class="min-w-full divide-y divide-slate-200">          
            <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                No.
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                <button @click="toggleSort('name')" type="button">
                  Name
                </button>
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
               
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500">
                <button @click="toggleSort('price')" type="button">
                  Price
                </button>
              </th>              
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
          <tr v-for="(product, index) in products.data" :key="product.id">   

            <td class="px-6 py-4 text-sm text-slate-500">
              {{ index + 1 }}
            </td>
            <td class="px-6 py-4 text-sm font-medium text-slate-900">
              {{ product.name }}
            </td>

             <td class="px-6 py-4">
                <img
                  v-if="product.image"
                  :src="product.image"
                  @click="openGallery(product)"
                  class="h-14 w-14 cursor-pointer rounded-lg object-cover border hover:opacity-80"
                />
                <div
                  v-else
                  class="flex h-14 w-14 items-center justify-center rounded-lg border bg-slate-100 text-xs text-slate-400"
                >
                  No Image
                </div>
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

         <td class="px-6 py-4">
            <div class="flex justify-end gap-2">
              <Link
                :href="`/products/${product.id}/edit`"
                class="inline-flex items-center justify-center rounded-lg bg-blue-100 p-2 text-blue-600 hover:bg-blue-200"
                title="Edit"
              >
                <i class="fa-solid fa-pen-to-square"></i>
              </Link>

              <button
                  @click="deleteProduct(product.id)"
                  class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-red-100 p-2 text-red-600 hover:bg-red-200"
                >
                <i class="fa-solid fa-trash"></i>
              </button>
            </div>
          </td>
          </tr>
        </tbody>
        </table>
          <div class="flex flex-col gap-4 border-t border-slate-200 px-6 py-4 md:flex-row md:items-center md:justify-between">
          <div class="text-sm text-slate-500">
            Showing {{ products.from }} to {{ products.to }} of {{ products.total }} products
          </div>

          <div class="flex flex-wrap items-center gap-2">
            <button
              v-for="link in products.links"
              :key="link.label"
              @click="goToPage(link.url)"
              :disabled="!link.url"
              v-html="link.label"
              class="rounded-lg px-3 py-2 text-sm font-medium transition"
              :class="[
                link.active
                  ? 'bg-indigo-600 text-white'
                  : link.url
                  ? 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                  : 'cursor-not-allowed bg-slate-50 text-slate-300'
              ]"
            />
          </div>
        </div>
        <div
            v-if="showGallery"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-6"
          >
            <div class="relative w-full max-w-4xl rounded-2xl bg-white p-4 shadow-xl">
              <button
                @click="closeGallery"
                class="absolute right-4 top-4 rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
              >
                Close
              </button>

              <div class="flex items-center justify-between gap-4">
                <button
                  @click="prevImage"
                  class="rounded-xl bg-slate-100 px-4 py-3 text-lg font-bold text-slate-700 hover:bg-slate-200"
                >
                  ‹
                </button>

                <div class="flex-1">
                  <img
                    v-if="currentImage"
                    :src="currentImage"
                    class="mx-auto max-h-[70vh] w-auto rounded-xl object-contain"
                  />
                </div>

                <button
                  @click="nextImage"
                  class="rounded-xl bg-slate-100 px-4 py-3 text-lg font-bold text-slate-700 hover:bg-slate-200"
                >
                  ›
                </button>
              </div>

              <div
                v-if="selectedProduct?.allImages?.length"
                class="mt-4 flex flex-wrap justify-center gap-2"
              >
                <button
                  v-for="(image, index) in selectedProduct.allImages"
                  :key="index"
                  @click="activeImageIndex = index"
                  class="overflow-hidden rounded-lg border-2"
                  :class="index === activeImageIndex ? 'border-indigo-500' : 'border-transparent'"
                >
                  <img :src="image" class="h-16 w-16 object-cover" />
                </button>
              </div>
            </div>
          </div>
      </template>
      </div>
    </div>
  </AppLayout>
</template>