<template>
    <q-layout view="hHh Lpr lff">
        <q-page-container>
            <slot />
        </q-page-container>
    </q-layout>
</template>

<script setup>
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
                    color: key,
                    timeout: 3000,
                    position: "top",
                });
            }
        }
    }
});
</script>
