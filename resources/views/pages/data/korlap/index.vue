<template layout>
  <q-page padding>
    <q-card class="my-card">
      <q-card-section>
        <q-card-section class="row">
          <div class="text-h6 col-auto q-mb-md">Kordinator Lapangan</div>
          <q-space />

          <!-- <div>
            <q-btn
              color="primary"
              icon="add"
              label="Tambah"
              @click="visit('/data/korlap/create')"
            />
          </div> -->
        </q-card-section>
        <div class="row q-col-gutter-md q-mb-lg">
          <div class="col-md-3 col-12">
            <q-select
              v-model="organisasi_id"
              id="organisasi_id"
              :options="options"
              track-by="id"
              emit-value
              @filter="filterFn"
              @update:model-value="onFilter"
              map-options
              option-label="nama_organisasi"
              option-value="id"
              :loading="loading"
              label="Organisasi"
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
            <q-table
              :rows="korlaps"
              :columns="columns"
              row-key="id"
              :loading="loading"
              flat
              @row-dblclick="dblclick"
            >
              <!-- qrcode -->
              <template v-slot:body-cell-qrcode="qrcode">
                <q-td :props="qrcode">
                  <div class="q-gutter-sm">
                    <template>
                      <div class="q-pa-md q-gutter-sm">
                        <q-dialog v-model="qrcode.expand">
                          <q-card>
                            <q-card-section>
                              <div class="text-h6">
                                QR Code
                                {{ qrcode.row.name }}
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
                                        Korlap
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
                                          :src="`/qr-code/generate?data=${qrcode.row.no}`"
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
                                        {{ qrcode.row.user.name }}
                                      </q-item-label>
                                      <q-item-label
                                        style="
                                          text-align: center;
                                          font-size: 19px;
                                        "
                                      >
                                        {{
                                          qrcode.row.organisasi.nama_organisasi
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
                      @click="qrcode.expand = true"
                    />
                  </div>
                </q-td>
              </template>
              <!-- action -->
              <template v-slot:body-cell-button="props">
                <q-td :props="props">
                  <div class="q-gutter-sm">
                    <template>
                      <div class="q-pa-md q-gutter-sm">
                        <q-dialog>
                          <q-card>
                            <q-card-section>
                              <div class="text-h6">Data Relawan</div>
                            </q-card-section>

                            <q-separator />
                            <q-form @submit="onSubmit">
                              <q-card-section>
                                <template
                                  v-for="(item, index) in inputForm"
                                  :key="index"
                                >
                                  <q-badge
                                    >Relawan :
                                    {{ index + 1 }}
                                  </q-badge>
                                  <div class="row q-col-gutter-md">
                                    <div class="col-md-4 col-6">
                                      <q-select
                                        :options="users"
                                        v-model="item.nik"
                                        dense
                                        use-input
                                        outlined
                                        option-value="id"
                                        option-label="name"
                                        label="NIK"
                                        @update:model-value="
                                          (val) => onSelectAnggota(val, item)
                                        "
                                      />
                                    </div>
                                    <div class="col-md-4 col-6">
                                      <q-select
                                        :options="users"
                                        v-model="item.user_id"
                                        use-input
                                        dense
                                        outlined
                                        option-value="id"
                                        option-label="name"
                                        label="Nama "
                                        @update:model-value="
                                          (val) => onSelectAnggota(val, item)
                                        "
                                      />
                                    </div>

                                    <div class="col-md-2 col-12">
                                      <q-btn
                                        color="red"
                                        icon="delete"
                                        dense
                                        @click="onDeleteItem(item, index)"
                                      />
                                    </div>
                                  </div>
                                </template>
                              </q-card-section>
                            </q-form>
                            <q-card-section>
                              <div class="row q-mt-md">
                                <q-space />
                                <div class="col-auto q-mb-md q-mr-sm">
                                  <q-btn
                                    @click="onAddInputForm"
                                    style="max-width: 300px"
                                    color="indigo-12"
                                    icon="add"
                                    type="submit"
                                    :loading="loading"
                                  />
                                </div>
                              </div>
                            </q-card-section>

                            <q-separator />

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
                      icon="edit"
                      @click="visit(`/data/korlap/${props.row.id}/edit`)"
                    />
                    <q-btn
                      dense
                      size="sm"
                      color="info"
                      icon="visibility"
                      @click="props.row.show_details = !props.row.show_details"
                    />

                    <q-btn
                      dense
                      size="sm"
                      color="red"
                      icon="delete"
                      @click="onDelete(props)"
                    />
                  </div>

                  <q-dialog v-model="props.row.show_details">
                    <q-card style="width: 400px; max-width: 80vw">
                      <q-card-section class="row items-center q-py-sm">
                        <div class="text-h6">Peserta</div>
                        <q-space />
                        <q-btn icon="close" flat round dense v-close-popup />
                      </q-card-section>

                      <q-separator />
                      <q-markup-table flat dense>
                        <thead>
                          <tr>
                            <th class="text-left">NIK</th>
                            <th class="text-left">NAMA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <template v-for="item in props.row.details">
                            <tr>
                              <td class="text-left">
                                {{ item.user?.nik }}
                              </td>
                              <td class="text-left">
                                {{ item.user?.name }}
                              </td>
                            </tr>
                          </template>
                        </tbody>
                      </q-markup-table>
                    </q-card>
                  </q-dialog>
                </q-td>
              </template>

              <template template v-slot:body-cell-count="props">
                <q-td :props="props">
                  <q-badge color="blue" :label="props.row.details.length" />
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
import { reactive, ref, watch } from "vue";

const props = defineProps(["korlaps", "users ", "organisasis"]);

const loading = ref(false);
const fixed = ref(false);
const onDelete = ({ row }) => {
  Inertia.delete(`/data/korlap/${row.id}`);
};

const visit = (path) => {
  Inertia.visit(path);
};
const dblclick = (evt, row, index) => {
  console.log(row.id);
  Inertia.visit(`/pengadaan/order-pembelian/${row.id}`);
};
const columns = [
  {
    name: "no",
    field: "no",
    label: "Kode",
    align: "left",
  },
  {
    name: "organisasi",
    field: "organisasi",
    label: "Nama Organisasi",
    align: "left",
    sortable: true,
    format: (val) => val.nama_organisasi,
  },

  {
    name: "user",
    field: "user",
    label: "Nama Korlap",
    align: "left",
    sortable: true,
    format: (val) => val.name,
  },
  {
    name: "user",
    field: "user",
    label: "No HP",
    align: "left",
    sortable: true,
    format: (val) => val.phone,
  },
  {
    name: "user",
    field: "user",
    label: "Alamat",
    align: "left",
    sortable: true,
    format: (val) => val.nik,
  },
  {
    name: "user",
    field: "user",
    label: "Kecamatan",
    align: "left",
    sortable: true,
    format: (val) => val?.wilayah?.detail?.name,
  },
  {
    name: "count",
    label: "Peserta",
    align: "center",
  },
  {
    name: "qrcode",
    label: "QRCode",
    align: "center",
  },
  {
    name: "button",
    label: "ACTION",
    align: "center",
  },
];
// search
const search = ref(null);
const organisasi_id = ref(null);
const options = ref(props.organisasis);
const filterFn = (val, update, abort) => {
  update(() => {
    const needle = val.toLowerCase();
    options.value = props.organisasis.filter(
      (v) => v.nama_organisasi.toLowerCase().indexOf(needle) > -1
    );
  });
};
const onFilter = () => {
  Inertia.get(
    "/data/korlap",
    {
      search: search.value,
      organisasi_id: organisasi_id.value,
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

// peserta korlap
const inputForm = ref([
  {
    nik: "",
    user_id: "",
  },
]);
const onAddInputForm = () => {
  inputForm.value.push({
    nik: "",
    nama: "",
  });
};
const onDeleteItem = (item, i) => {
  const index = inputForm.value.indexOf(item);
  if (index > -1) {
    inputForm.value.splice(index, 1);
  }
};
const onSubmit = () => {
  Inertia.post(
    "/data/korlap",
    {
      //   ...form,
      items: inputForm.value,
    },
    {
      onFinish: () => {
        loading.value = false;
      },
    }
  );
};
// Detail
const onRowDoubleClick = () => {
  alert("dbclick");
};
</script>

<style lang="scss" scoped></style>
