<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  products: Array
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
           Back
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
          <div class="aspect-[4/5] w-full bg-slate-100">
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
            <p class="mt-2 text-lg font-bold text-slate-900">
              RM{{ product.quantity * 10 }}
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
  </div>
</template>