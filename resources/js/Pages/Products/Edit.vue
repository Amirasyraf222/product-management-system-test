<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import ProductForm from '../../Components/ProductForm.vue';

const props = defineProps({
  product: Object,
  categories: Array,
});
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <div>
        <h2 class="text-2xl font-bold text-slate-900">Edit Product</h2>
        <p class="text-sm text-slate-500">Update the product details below.</p>
      </div>

      <ProductForm
        :product="product"
        :categories="categories"
        submit-label="Update Product"
        :submit-url="`/products/${product.id}`"
        method="put"
      />
    </div>
  </AppLayout>
</template>
