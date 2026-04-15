<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import ProductForm from '../../Components/ProductForm.vue';

defineProps({
  categories: Array,
});
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <div>
        <h2 class="text-2xl font-bold text-slate-900">Create Product</h2>
        <p class="text-sm text-slate-500">Add a new product and assign it to a category.</p>
      </div>

      <ProductForm :categories="categories" submit-label="Create Product" submit-url="/products" />
    </div>
  </AppLayout>
</template>
