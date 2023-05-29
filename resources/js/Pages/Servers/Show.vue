<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue'
import ChannelsExplorer from '@/Components/ChannelsExplorer.vue'

defineProps({
  server: Object,
})
</script>

<template>
  <Layout>
    <template #explorer>
      <ChannelsExplorer :server="server" />
    </template>

    <template #main>
      <div>server show page</div>
    </template>
  </Layout>
</template>
