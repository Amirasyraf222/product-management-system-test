<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();
const sidebarOpen = ref(false);

const isActive = (path) => {
  return page.url.startsWith(path);
};

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

const closeSidebar = () => {
  sidebarOpen.value = false;
};
</script>

<template>
  <div class="min-h-screen bg-slate-100">
    <header class="border-b border-slate-200 bg-white px-6 py-4 shadow-sm">
      <div class="flex items-center gap-3">
        <button
          type="button"
          @click="toggleSidebar"
          class="inline-flex items-center justify-center rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
        >
          ☰ Menu
        </button>

        <h1 class="text-xl font-bold text-slate-900">
          Product Management System
        </h1>
      </div>
    </header>

    <div
      v-if="sidebarOpen"
      @click="closeSidebar"
      class="fixed inset-0 z-40 bg-black/30"
    ></div>

    <aside
      class="fixed left-0 top-0 z-50 h-full w-72 transform border-r border-slate-200 bg-white shadow-xl transition-transform duration-300"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
        <div>
          <h2 class="text-lg font-bold text-slate-900">Management</h2>
        </div>

        <button
          type="button"
          @click="closeSidebar"
          class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
        >
          ✕
        </button>
      </div>

      <nav class="space-y-2 p-4">
        <Link
          href="/categories"
          @click="closeSidebar"
          class="block rounded-xl px-4 py-3 text-sm font-medium transition"
          :class="isActive('/categories') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100'"
        >
          Manage Categories
        </Link>
           <Link
          href="/products"
          @click="closeSidebar"
          class="block rounded-xl px-4 py-3 text-sm font-medium transition"
          :class="isActive('/products') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100'"
        >
          Manage Products
        </Link>
      </nav>
    </aside>

    <main class="p-8">
      <slot />
    </main>
  </div>
</template>