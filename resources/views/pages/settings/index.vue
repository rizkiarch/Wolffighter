<template layout>
    <q-page padding>
        <q-tabs
            dense
            align="left"
            v-model="tab"
            mobile-arrows
            outside-arrows
            class="text-primary"
        >
            <q-tab name="general" label="General" />
            <q-tab name="payment" label="payment" />
            <q-tab name="user" label="user" />
        </q-tabs>

        <q-separator />

        <q-tab-panels
            v-model="tab"
            animated
            swipeable
            transition-prev="jump-left"
            transition-next="jump-right"
        >
            <q-tab-panel name="general">
                <div class="text-h6 q-mb-md">General Setting</div>
            </q-tab-panel>

            <q-tab-panel name="payment">
                <div class="text-h6 q-mb-md">Payment Setting</div>
            </q-tab-panel>

            <q-tab-panel name="user">
                <div class="text-h6 q-mb-md">User Setting</div>
            </q-tab-panel>
        </q-tab-panels>
    </q-page>
</template>

<script setup>
import { ref } from "vue";

const tab = ref("general");

const navDelay = (e) => {};
</script>

<style lang="scss" scoped></style>
