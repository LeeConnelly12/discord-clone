<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  server: Object,
  category: Object,
})

const open = ref(true)
</script>

<template>
  <ul>
    <button @click="open = !open" class="uppercase flex w-full items-center gap-[2px] h-6" type="button">
      <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform transition-transform" :class="{ '-rotate-90': !open }">
        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
      </svg>
      <p class="text-xs text-opacity-80 text-white hover:text-opacity-100">{{ category.name }}</p>
    </button>
    <li v-if="open" v-for="channel in category.channels" :key="channel.id" class="flex items-center gap-1 rounded-md" :class="route().current('servers.channels.show', [server, channel]) ? 'bg-slate-500' : 'hover:bg-slate-600'">
      <Link :href="route('servers.channels.show', [server, channel])" class="flex w-full cursor-pointer items-center gap-1 h-8 pl-4">
        <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
          <path fill-rule="evenodd" d="M9.493 2.853a.75.75 0 00-1.486-.205L7.545 6H4.198a.75.75 0 000 1.5h3.14l-.69 5H3.302a.75.75 0 000 1.5h3.14l-.435 3.148a.75.75 0 001.486.205L7.955 14h2.986l-.434 3.148a.75.75 0 001.486.205L12.456 14h3.346a.75.75 0 000-1.5h-3.14l.69-5h3.346a.75.75 0 000-1.5h-3.14l.435-3.147a.75.75 0 00-1.486-.205L12.045 6H9.059l.434-3.147zM8.852 7.5l-.69 5h2.986l.69-5H8.852z" clip-rule="evenodd" />
        </svg>
        {{ channel.name }}
      </Link>
    </li>
  </ul>
</template>
