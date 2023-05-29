<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue'
import ChannelsExplorer from '@/Components/ChannelsExplorer.vue'
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'

const props = defineProps({
  server: Object,
  channel: Object,
})

const form = useForm({
  text: '',
})

function submit() {
  form.post(route('servers.channels.send-message', [props.server, props.channel]), {
    onSuccess: () => form.reset('text'),
  })
}

Echo.private(`servers.${props.server.id}.channels.${props.channel.id}`).listen('MessageSent', (e) => {
  props.channel.messages.push(e.message)
})
</script>

<template>
  <Layout>
    <template #explorer>
      <ChannelsExplorer :server="server" />
    </template>

    <template #main>
      <div class="px-4">
        <div v-for="message in channel.messages" :key="message.id">{{ message.text }}</div>
      </div>

      <form @submit.prevent="submit" class="px-4">
        <TextInput v-model="form.text" type="text" class="block w-full" :placeholder="`Message #${channel.name}`" />
        <InputError :message="form.errors.text" class="mt-2" />
      </form>
    </template>
  </Layout>
</template>
