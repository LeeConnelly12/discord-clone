<script setup>
import Sidebar from '@/Components/Sidebar.vue'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const user = computed(() => usePage().props.auth.user)
</script>

<template>
  <div class="grid grid-cols-[72px,240px,1fr] h-screen overflow-y-hidden">
    <Sidebar :servers="user.servers" />
    <slot name="explorer" />
    <main class="relative pt-12 h-screen">
      <div class="h-12 bg-slate-400 absolute left-0 top-0 right-0 z-10"></div>
      <slot name="main" />
    </main>
  </div>
</template>
