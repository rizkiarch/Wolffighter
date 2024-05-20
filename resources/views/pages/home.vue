<template layout>
  <q-page padding class="q-mt-md">
    <q-card class="my-card" flat>
      <div class="text-h6 col-auto q-ml-md q-mb-lg q-gutter-md"></div>
      <q-space />
      <div class="col-md-6 col-12 q-ml-md q-mt-sm">
        <div class="row col-md-6 col-12 justify-center">
          <q-btn
            @click="visit('/dashboard')"
            rounded
            class="q-mr-md q-mb-sm"
            color="red-6"
            push
            style="width: 100px; height: 100px"
          >
            <q-icon name="dashboard" size="45px" />
            <div class="row items-center q-px-xl q-px-xl">
              <div>Dashboard<br /></div>
            </div>
          </q-btn>
          <q-btn
            @click="visit('/data/region')"
            rounded
            class="q-mr-md q-mb-sm"
            color="red-6"
            push
            style="width: 100px; height: 100px"
          >
            <q-icon name="public" size="45px" />
            <div class="row items-center q-px-xl q-px-xl">
              <div>Region<br /></div>
            </div>
          </q-btn>
          <q-btn
            @click="visit('/data/sub-region')"
            rounded
            class="q-mr-md q-mb-sm"
            color="red-6"
            push
            style="width: 100px; height: 100px"
          >
            <q-icon name="south_america" size="45px" />
            <div class="row items-center q-px-xl q-px-xl">
              <div>Sub-region<br /></div>
            </div>
          </q-btn>
          <q-btn
            @click="visit('/data/organisasi')"
            rounded
            class="q-mr-md q-mb-sm"
            color="red-6"
            push
            style="width: 100px; height: 100px"
          >
            <q-icon name="groups" size="45px" />
            <div class="row items-center q-px-xl q-px-xl">
              <div>Organisasi<br /></div>
            </div>
          </q-btn>
          <q-btn
            @click="visit('/data/korlap')"
            rounded
            class="q-mr-md q-mb-sm"
            color="red-6"
            push
            style="width: 100px; height: 100px"
          >
            <q-icon name="engineering" size="45px" />
            <div class="row items-center q-px-xl q-px-xl">
              <div>Korlap<br /></div>
            </div>
          </q-btn>
          <q-btn
            @click="visit('/data/relawan')"
            rounded
            class="q-mr-md q-mb-sm"
            color="red-6"
            push
            style="width: 100px; height: 100px"
          >
            <q-icon name="emoji_people" size="45px" />
            <div class="row items-center q-px-xl q-px-xl">
              <div>Relawan<br /></div>
            </div>
          </q-btn>
          <q-btn
            @click="visit('/data/kehadiran')"
            rounded
            class="q-mr-md q-mb-sm"
            color="red-6"
            push
            style="width: 100px; height: 100px"
          >
            <q-icon name="assignment_ind" size="45px" />
            <div class="row items-center q-px-xl q-px-xl">
              <div>Kehadiran<br /></div>
            </div>
          </q-btn>
          <q-btn
            @click="visit('/auth/logout')"
            rounded
            class="q-mr-lg q-mb-xl"
            color="red-14"
            push
            style="width: 100px; height: 100px"
          >
            <q-icon name="logout" size="45px" />
            <div class="row items-center q-px-xl q-px-xl">
              <div>Logout<br /></div>
            </div>
          </q-btn>
        </div>
      </div>
    </q-card>
  </q-page>
</template>

<script setup>
import logo from "assets/logo.svg";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";

const visit = (path) => {
  Inertia.visit(path);
};
</script>

<style lang="scss" scoped></style>
