<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
import Swal from 'sweetalert2';

defineProps({
  categories: Array,
});


const deleteCategory = async (id) => {
  const url = `${window.location.origin}/categories/${id}`;
  console.log('Deleting category id:', id);
  console.log('DELETE URL:', url);

  const result = await Swal.fire({
    title: 'Delete Category?',
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#64748b',
    confirmButtonText: 'Delete',
    cancelButtonText: 'Cancel'
  });

  if (!result.isConfirmed) return;

  try {
    const response = await fetch(url, {
      method: 'DELETE',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
      },
    });

    const data = await response.json();

    if (!response.ok) {
      await Swal.fire({
        icon: 'error',
        title: 'Unable to Delete',
        text: data.message || 'Something went wrong.',
      });
      return;
    }

    await Swal.fire({
      icon: 'success',
      title: 'Success',
      text: data.message || 'Category deleted successfully.',
    });

    window.location.reload();
  } catch (error) {
    console.error(error);

    await Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Something went wrong while deleting the category.',
    });
  }
};
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-end justify-between">
        <div>
          <h2 class="text-2xl font-bold text-slate-900">Categories</h2>
          <p class="text-sm text-slate-500">
            Manage your product categories here.
          </p>
        </div>

        <Link
          href="/categories/create"
          class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
        >
          Add Category
        </Link>
      </div>

      <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div v-if="categories.length === 0" class="px-6 py-12 text-center">
          <h3 class="text-lg font-semibold text-slate-900">No categories found</h3>
          <p class="mt-2 text-sm text-slate-500">Create your first category.</p>
        </div>

        <table v-else class="min-w-full divide-y divide-slate-200">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">No.</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500">Name</th>
              <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-slate-500">Action</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-slate-100 bg-white">
            <tr v-for="(category, index) in categories" :key="category.id">
              <td class="px-6 py-4 text-sm text-slate-500">
                {{ index + 1 }}
              </td>

              <td class="px-6 py-4 text-sm font-medium text-slate-900">
                {{ category.name }}
              </td>

              <td class="px-6 py-4">
                <div class="flex justify-end gap-2">
                  <Link
                    :href="`/categories/${category.id}/edit`"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-100 p-2 text-blue-600 hover:bg-blue-200"
                    title="Edit"
                  >
                    <i class="fa-solid fa-pen-to-square"></i>
                  </Link>

               <button
                type="button"
                @click.stop.prevent="deleteCategory(category.id)"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-red-100 p-2 text-red-600 hover:bg-red-200"
                title="Delete"
                >
                <i class="fa-solid fa-trash"></i>
                </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>