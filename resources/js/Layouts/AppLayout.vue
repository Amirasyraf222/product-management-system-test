<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
  <div class="min-h-screen bg-slate-50">
    <header class="border-b border-slate-200 bg-white">
      <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <div>
          <h1 class="text-xl font-bold text-slate-900">Product Management System</h1>
          <p class="text-sm text-slate-500">Laravel + Vue 3 + Inertia + Tailwind</p>
        </div>
        <nav class="flex items-center gap-3">
          <Link
            href="/products"
            class="rounded-lg px-4 py-2 text-sm font-medium transition"
            :class="$page.component === 'Products/Index' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
          >
            Products
          </Link>
          <Link
            href="/products/create"
            class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
          >
            Add Product
          </Link>
        </nav>
      </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-8">
      <div
        v-if="page.props.flash?.success"
        class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
      >
        {{ page.props.flash.success }}
      </div>

      <slot />
    </main>
  </div>
</template>
