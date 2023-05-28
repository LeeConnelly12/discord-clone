<script setup>
import Sidebar from "@/Components/Sidebar.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const user = computed(() => usePage().props.auth.user);
</script>

<template>
    <div class="grid grid-cols-[72px,1fr] min-h-screen">
        <Sidebar :servers="user.servers" />
        <main>
            <div class="h-12 bg-slate-400"></div>
            <slot />
        </main>
    </div>
</template>
