<template>
    <q-layout view="hHh Lpr lff">
        <layout-header />
        <layout-drawer />

        <q-page-container>
            <slot />
        </q-page-container>
    </q-layout>
</template>

<script setup>
// This is a peristent layout
// Include me with <template layout="default" />

import { useMainStore } from "@/stores/main";
import LayoutHeader from "@/views/components/layouts/header.vue";
import LayoutDrawer from "@/views/components/layouts/drawer.vue";

import { Notify } from "quasar";
import { usePage } from "@inertiajs/inertia-vue3";
import { computed, watch } from "vue-demi";

const flash = computed(() => usePage().props.value.flash);
watch(flash, (value) => {
    for (const key in value) {
        if (Object.hasOwnProperty.call(value, key)) {
            const message = value[key];
            if (message) {
                Notify.create({
                    message,
                    type: key,
                    timeout: 3000,
                    position: "top",
                });
            }
        }
    }
});

const main = useMainStore();
</script>
