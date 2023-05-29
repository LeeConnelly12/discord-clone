<script setup>
import ChannelsAccordion from '@/Components/ChannelAccordion.vue'

defineProps({
  server: Object,
})
</script>

<template>
  <aside class="bg-slate-700 text-white">
    <button class="px-4 py-3 w-full text-left">{{ server.name }}</button>
    <nav class="text-sm grid gap-4 px-1 mt-4" aria-label="Channels navigation">
      <ChannelsAccordion v-for="category in server.categories" :key="category.id" :server="server" :category="category" />
    </nav>
  </aside>
</template>
