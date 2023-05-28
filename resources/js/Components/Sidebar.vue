<script setup>
import { Link } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    servers: Array,
});

const form = useForm({
    name: "",
});

const creatingServer = ref(false);

function openModal() {
    creatingServer.value = true;
}

function closeModal() {
    creatingServer.value = false;
}

function submit() {
    form.post(route("servers.store"), {
        onSuccess: () => (creatingServer.value = false),
    });
}
</script>

<template>
    <aside class="bg-slate-100">
        <nav class="grid gap-2 justify-center pt-3">
            <Link
                v-for="server in servers"
                :key="server.id"
                :href="route('servers.show', server)"
            >
                <div class="w-12 h-12 rounded-full bg-slate-600"></div>
            </Link>
            <button
                @click="openModal"
                class="w-12 h-12 rounded-full bg-slate-400 grid place-items-center"
                type="button"
            >
                <svg viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7">
                    <path
                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"
                    />
                </svg>
            </button>
        </nav>
    </aside>

    <Modal :show="creatingServer" @close="closeModal" max-width="md">
        <form @submit.prevent="submit" class="p-6">
            <h2 class="text-center font-medium text-gray-900">
                Create your server
            </h2>

            <p class="mt-1 text-center text-sm text-gray-600">
                Give your new server a personality with a name and an icon. You
                can always change it later.
            </p>

            <div class="mt-6">
                <InputLabel for="name" value="Server name" />

                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-3/4"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button @click="closeModal" type="button">Cancel</button>
                <button class="ml-3" type="submit">Create</button>
            </div>
        </form>
    </Modal>
</template>
