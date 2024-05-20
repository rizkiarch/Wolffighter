<template>
  <q-header class="bg-red-6">
    <q-toolbar>
      <q-btn
        flat
        @click="main.setDrawer(!main.drawer)"
        round
        dense
        icon="menu"
      />
      <q-toolbar-title>Menu</q-toolbar-title>
    </q-toolbar>
  </q-header>
</template>

<script setup>
import { useMainStore } from "@/stores/main";

const main = useMainStore();
</script>

<style lang="scss" scoped>
.q-header {
  -webkit-backdrop-filter: blur(7px);
  backdrop-filter: blur(7px);
  background-color: #0000001a;
}
</style>
