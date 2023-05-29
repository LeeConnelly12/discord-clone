<script setup>
import ChannelsAccordion from '@/Components/ChannelAccordion.vue'

defineProps({
  server: Object,
})
</script>

<template>
  <aside class="bg-slate-700 text-white overflow-y-auto pb-6 thin-scrollbar transparent-scrollbar">
    <button class="px-4 py-3 w-full text-left transition-colors shadow-[0_0_1px_1px_black] hover:bg-white/10 flex items-center justify-between">
      <p class="font-bold">{{ server.name }}</p>
      <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
      </svg>
    </button>
    <nav class="text-sm grid gap-4 px-1 mt-4" aria-label="Channels navigation">
      <ChannelsAccordion v-for="category in server.categories" :key="category.id" :server="server" :category="category" />
    </nav>
  </aside>
</template>
