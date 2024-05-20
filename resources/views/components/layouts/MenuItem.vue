<template>
  <template v-if="!expansion">
    <q-item
      clickable
      v-bind="attrs"
      @click="visit(menu.url)"
      :disable="!menu.is_active"
      active-class="app-menu-active"
      :active="isActive($page, menu)"
    >
      <q-item-section avatar>
        <q-icon :name="menu.icon" color="red-6" />
      </q-item-section>

      <q-item-section>
        {{ menu.name }}
      </q-item-section>

      <slot />
    </q-item>
  </template>

  <template v-if="expansion">
    <q-expansion-item v-bind="attrs" :default-opened="isActive($page, menu)">
      <template #header>
        <q-item-section avatar>
          <q-icon :name="menu.icon" color="red-6" />
        </q-item-section>

        <q-item-section>
          {{ menu.name }}
        </q-item-section>
      </template>

      <slot />
    </q-expansion-item>
  </template>
</template>

<script setup>
import { useAttrs } from "vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
  menu: Object,
  expansion: Boolean,
});

const attrs = useAttrs();

const defaultConfig = {
  method: "get",
  data: {},
  replace: false,
  preserveState: false,
  preserveScroll: false,
  only: [],
  headers: {},
  errorBag: null,
  forceFormData: false,
  onCancelToken: (cancelToken) => {},
  onCancel: () => {},
  onBefore: (visit) => {},
  onStart: (visit) => {
    // main.loadingVisit = true;
  },
  onProgress: (progress) => {},
  onSuccess: (page) => {},
  onError: (errors) => {},
  onFinish: (visit) => {
    // main.loadingVisit = false;
  },
};

const visit = (url, config = {}) => {
  Inertia.visit(url, {
    ...defaultConfig,
    ...config,
  });
};

const isActive = (page, menu) => {
  if (menu.children.length > 0) {
    return page.url.startsWith(menu.url);
  }

  return page.url === menu.url;
};
</script>
