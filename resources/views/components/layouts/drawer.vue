<template>
  <div>
    <q-ajax-bar ref="bar" position="top" color="info" size="3px" skip-hijack />

    <q-drawer
      :model-value="main.drawer"
      :width="250"
      :breakpoint="500"
      bordered
      class="bg-grey-1"
    >
      <q-scroll-area class="fit">
        <q-list dense class="app-menu">
          <template v-for="(menu, key) in menus" :key="key">
            <template v-if="menu.children.length == 0">
              <MenuItem :menu="menu" />
            </template>

            <template v-if="menu.children.length > 0">
              <MenuItem dense expansion :menu="menu" :content-inset-level="0.1">
                <template v-for="(menu2, key2) in menu.children" :key="key2">
                  <template v-if="menu2.children.length === 0">
                    <MenuItem dense clickable :menu="menu2" />
                  </template>

                  <template v-if="menu2.children.length > 0">
                    <MenuItem
                      dense
                      expansion
                      :menu="menu2"
                      :content-inset-level="0.1"
                    >
                      <template
                        v-for="(menu3, key3) in menu2.children"
                        :key="key3"
                      >
                        <template v-if="menu3.children.length === 0">
                          <MenuItem dense clickable :menu="menu3" />
                        </template>
                      </template>
                    </MenuItem>
                  </template>
                </template>
              </MenuItem>
            </template>
          </template>
        </q-list>
      </q-scroll-area>
    </q-drawer>
  </div>
</template>

<script setup>
import MenuItem from "./MenuItem.vue";
import { computed, watch, ref } from "vue";
import { useMainStore } from "@/stores/main";
import { usePage } from "@inertiajs/inertia-vue3";

const bar = ref(null);
const main = useMainStore();
const loadingVisit = computed(() => main.loadingVisit);
const menus = computed(() => usePage().props.value.menus);

watch(loadingVisit, (loading) => {
  const barRef = bar.value;
  if (loading) {
    barRef.start();
  } else {
    barRef.stop();
  }
});
</script>

<style lang="scss">
.app-menu {
  .q-item {
    font-size: 12px;
  }
  .q-expansion-item {
    font-size: 12px;
  }

  .q-expansion-item__content {
    .q-item {
      border-radius: 0 10px 10px 0;
      margin-right: 12px;
    }
  }

  .app-menu-active {
    background-color: rgb(24 118 210 / 10%);
  }
}
</style>
