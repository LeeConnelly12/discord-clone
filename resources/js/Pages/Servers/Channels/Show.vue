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
  props.channel.messages.push(e)
})
</script>

<template>
  <Layout>
    <template #explorer>
      <ChannelsExplorer :server="server" />
    </template>

    <template #main>
      <div class="px-4 pt-6 pb-20 overflow-y-scroll h-[calc(100vh-48px)]">
        <ul class="w-full grid gap-5">
          <li v-for="message in channel.messages" :key="message.id" class="grid gap-3 items-center grid-cols-[40px,max-content,max-content]">
            <div class="h-10 rounded-full bg-slate-300"></div>
            <div>
              <p class="font-bold">
                {{ message.user.username }} <span class="opacity-50 text-xs font-normal ml-1">{{ message.sent_at }}</span>
              </p>
              <p class="col-span-full">{{ message.text }}</p>
            </div>
          </li>
        </ul>
      </div>

      <form @submit.prevent="submit" class="px-4 absolute left-0 bottom-0 right-0 pb-5 bg-white">
        <TextInput v-model="form.text" type="text" class="block w-full" :placeholder="`Message #${channel.name}`" />
        <InputError :message="form.errors.text" class="mt-2" />
      </form>
    </template>
  </Layout>
</template>
