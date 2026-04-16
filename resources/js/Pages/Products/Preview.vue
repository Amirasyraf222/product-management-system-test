<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  products: Array
});

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
</script>

<template>
  <div class="min-h-screen bg-slate-100 py-8">
    <div class="mx-auto max-w-7xl px-6">

      <div class="mb-6 flex items-center gap-4">
        <Link
          href="/products"
          class="rounded-xl bg-red-500 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-red-600 transition"
        >
          ← Back
        </Link>

        <h1 class="text-2xl font-bold text-slate-900">
          Product Preview (User Experience)
        </h1>
      </div>

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="product in products"
          :key="product.id"
          class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >
          <div
            class="aspect-[4/5] w-full cursor-pointer bg-slate-100"
            @click="openGallery(product)"
          >
            <img
              v-if="product.image"
              :src="product.image"
              alt="Product Image"
              class="h-full w-full object-cover"
            />
            <div
              v-else
              class="flex h-full items-center justify-center text-sm text-slate-400"
            >
              Image
            </div>
          </div>

          <div class="p-4">
            <h2 class="line-clamp-2 text-base font-semibold text-slate-900">
              {{ product.name }}
            </h2>

            <p class="mt-2 text-lg font-bold text-slate-900">
              RM{{ Number(product.price).toFixed(2) }}
            </p>

            <p class="mt-1 text-sm text-slate-500">
              {{ product.category.name }}
            </p>

            <p class="mt-1 text-sm text-slate-400">
              Like new
            </p>
          </div>
        </div>
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

        <div v-if="selectedProduct?.allImages?.length" class="mt-4 flex flex-wrap justify-center gap-2">
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
  </div>
</template>