<script setup>
import { onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

onMounted(() => {
  setTimeout(() => {
    router.visit('/registration');
  }, 0.1);
});
</script>

<template>
   <div class="spinner-grow" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
</template>

<style scoped>
</style>