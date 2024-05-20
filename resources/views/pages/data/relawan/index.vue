<template layout>
  <q-page padding>
    <q-card class="my-card">
      <q-card-section>
        <q-card-section class="row">
          <div class="text-h6 col-auto">Relawan</div>
          <q-space />

          <div>
            <q-btn
              color="primary"
              icon="add"
              label="Relawan"
              @click="visit('/data/relawan/create')"
            />
          </div>
        </q-card-section>
        <div class="row q-col-gutter-md q-mb-lg">
          <div class="col-md-3 col-12">
            <q-select
              v-model="jenis_id"
              id="jenis_id"
              :options="options"
              track-by="id"
              emit-value
              @filter="filterFn"
              @update:model-value="onFilter"
              map-options
              option-label="name"
              option-value="id"
              :loading="loading"
              label="Jenis"
              debounce="600"
              filled
              dense
              clearable
              use-input
            >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          </div>
          <div class="col-md-4 col-12">
            <q-input
              filled
              v-model="search"
              debounce="600"
              placeholder="Search"
              :loading="loading"
              @update:model-value="onFilter"
              dense
            >
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </div>
        </div>
        <q-card class="form q-mb-md">
          <q-card-section>
            <q-table :rows="users" :columns="columns" row-key="id" flat>
              <!-- qrcode -->
              <template v-slot:body-cell-qrcode="props">
                <q-td :props="props">
                  <div class="q-gutter-sm">
                    <template>
                      <div class="q-pa-md q-gutter-sm">
                        <q-dialog v-model="props.expand">
                          <q-card>
                            <q-card-section>
                              <div class="text-h6">
                                QR Code {{ props.row.name }}
                              </div>
                            </q-card-section>

                            <q-separator />

                            <q-card-section>
                              <div class="row q-col-gutter-xs">
                                <q-list>
                                  <q-item>
                                    <q-item-section>
                                      <q-item-label
                                        style="
                                          text-align: center;
                                          font-weight: bold;
                                          font-size: 24px;
                                          text-transform: uppercase;
                                        "
                                      >
                                        {{ props.row.jenis.name }}
                                      </q-item-label>
                                      <q-item-label
                                        style="
                                          text-align: center;
                                          font-weight: bold;
                                          font-size: 16;
                                        "
                                      >
                                        SILATURAHMI AKBAR
                                      </q-item-label>
                                      <q-item-label
                                        style="
                                          text-align: center;
                                          font-weight: bold;
                                          font-size: 14px;
                                        "
                                      >
                                        Aliansi Relawan JOKOWI
                                      </q-item-label>
                                      <q-item-label
                                        style="
                                          text-align: center;
                                          font-weight: bold;
                                          font-size: 12px;
                                        "
                                      >
                                        Se-Banyumas Raya, 17 Juli 2022
                                      </q-item-label>
                                      <q-item-label style="text-align: center">
                                        <q-img
                                          width="300px"
                                          height="300px"
                                          :src="`/qr-code/generate?data=${props.row.no}`"
                                          spinner-color="primary"
                                          spinner-size="82px"
                                        />
                                      </q-item-label>
                                      <q-item-label
                                        style="
                                          text-align: center;
                                          font-weight: bold;
                                          font-size: 24px;
                                        "
                                      >
                                        {{ props.row.name }}
                                      </q-item-label>
                                      <q-item-label
                                        style="
                                          text-align: center;
                                          font-size: 19px;
                                        "
                                      >
                                        {{
                                          props.row.organisasi.nama_organisasi
                                        }}
                                      </q-item-label>
                                    </q-item-section>
                                  </q-item>
                                </q-list>
                              </div>
                            </q-card-section>

                            <q-separator />

                            <q-card-actions align="right">
                              <q-btn
                                flat
                                label="Close"
                                color="primary"
                                v-close-popup
                              />
                            </q-card-actions>
                          </q-card>
                        </q-dialog>
                      </div>
                    </template>
                    <q-btn
                      dense
                      size="sm"
                      color="info"
                      icon="qr_code_scanner"
                      @click="props.expand = true"
                    />
                  </div>
                </q-td>
              </template>
              <!-- action -->
              <template v-slot:body-cell-button="props">
                <q-td :props="props">
                  <div class="q-gutter-sm">
                    <q-btn
                      dense
                      size="sm"
                      color="info"
                      icon="edit"
                      @click="visit(`/data/relawan/${props.row.id}/edit`)"
                    />
                    <q-btn
                      dense
                      size="sm"
                      color="red"
                      icon="delete"
                      @click="onDelete(props)"
                    />
                  </div>
                </q-td>
              </template>
            </q-table>
          </q-card-section>
        </q-card>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";

const props = defineProps(["users", "jenis"]);
const loading = ref(false);

const onDelete = ({ row }) => {
  Inertia.delete(`/data/relawan/${row.id}`);
};

const visit = (path) => {
  Inertia.visit(path);
};

const columns = [
  {
    name: "jenis",
    field: "jenis",
    label: "Jenis",
    align: "left",
    sortable: true,
    format: (val) => val.name,
  },
  {
    name: "jabatan",
    field: "jabatan",
    label: "Jabatan",
    align: "left",
    sortable: true,
    format: (val) => val.nama_jabatan,
  },
  {
    name: "name",
    field: "name",
    label: "Nama",
    align: "left",
    sortable: true,
  },

  {
    name: "phone",
    field: "phone",
    label: "No HP",
    align: "left",
    sortable: true,
  },
  {
    name: "address",
    field: "address",
    label: "Alamat",
    align: "left",
    sortable: true,
  },
  {
    name: "jk",
    field: "jk",
    label: "Jenis Kelamin",
    align: "left",
    sortable: true,
  },
  {
    name: "organisasi",
    field: "organisasi",
    label: "Organisasi",
    align: "left",
    sortable: true,
    format: (val) => val.nama_organisasi,
  },
  {
    name: "qrcode",
    label: "QRCode",
    align: "center",
  },
  {
    name: "button",
    label: "Action",
    align: "left",
  },
];
const search = ref(null);
const options = ref(props.jenis);
const jenis_id = ref(null);
const filterFn = (val, update, abort) => {
  update(() => {
    const needle = val.toLowerCase();
    options.value = props.jenis.filter(
      (v) => v.name.toLowerCase().indexOf(needle) > -1
    );
  });
};
const onFilter = () => {
  Inertia.get(
    "/data/relawan",
    {
      search: search.value,
      jenis_id: jenis_id.value,
    },
    {
      preserveState: true,
      preserveScroll: true,
      replace: true,
      onFinish: () => {
        loading.value = false;
      },
      onBefore: () => {
        loading.value = true;
      },
    }
  );
};
</script>

<style lang="scss" scoped></style>
