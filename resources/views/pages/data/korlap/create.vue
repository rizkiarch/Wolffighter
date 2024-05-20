
<template layout>
  <q-page padding>
    <q-form @submit="onSubmit">
      <q-card class="my-card">
        <q-card-section>
          <div id="app">
            <q-card-section class="row">
              <div class="text-h6 col-auto q-mb-md">
                Data Kordinator Lapangan
              </div>
              <q-space />
            </q-card-section>
            <!-- top -->
            <q-card-section>
              <div class="row q-col-gutter-sm">
                <div class="col-md-6 col-12">
                  <div><p>Nama</p></div>
                  <q-select
                    :options="options"
                    @filter="filterFn"
                    v-model="form.user"
                    dense
                    use-input
                    outlined
                    option-value="id"
                    option-label="name"
                    label="Nama"
                    @update:model-value="onSelectUser"
                  />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>NIK</p></div>
                  <q-input dense outlined v-model="form.nik" readonly />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>No HP</p></div>
                  <q-input
                    type="number"
                    dense
                    v-model="form.nohp"
                    outlined
                    readonly
                  />
                </div>

                <div class="col-md-6 col-12">
                  <div><p>Provinsi</p></div>
                  <q-select
                    @update:model-value="(value) => onSelect(value, 'prov_id')"
                    dense
                    v-model="form.provinsi"
                    :options="prov"
                    :loading="loading_wilayah"
                    outlined
                    option-value="code"
                    option-label="name"
                    map-options
                    emit-value
                  />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>Kab./Kota</p></div>
                  <q-select
                    @update:model-value="(value) => onSelect(value, 'kab_id')"
                    dense
                    :disable="!form.provinsi"
                    v-model="form.kabupaten"
                    :loading="loading_wilayah"
                    :options="kab"
                    outlined
                    option-value="code"
                    option-label="name"
                    map-options
                    emit-value
                  />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>Kecamatan</p></div>
                  <q-select
                    @update:model-value="(value) => onSelect(value, 'kec_id')"
                    dense
                    :disable="!form.kabupaten"
                    v-model="form.kecamatan"
                    :loading="loading_wilayah"
                    :options="kec"
                    outlined
                    option-value="code"
                    option-label="name"
                    map-options
                    emit-value
                  />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>Desa/Kel.</p></div>
                  <q-select
                    @update:model-value="(value) => onSelect(value, 'desa_id')"
                    dense
                    :disable="!form.kecamatan"
                    v-model="form.desa"
                    :loading="loading_wilayah"
                    :options="desa"
                    outlined
                    option-value="code"
                    option-label="name"
                    map-options
                    emit-value
                  />
                </div>

                <div class="col-md-3 col-6">
                  <div><p>RT.</p></div>
                  <q-input outlined dense v-model="form.rt" readonly />
                </div>
                <div class="col-md-3 col-6">
                  <div><p>RW</p></div>
                  <q-input dense v-model="form.rw" outlined readonly />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>Alamat</p></div>
                  <q-input dense v-model="form.alamat" outlined readonly />
                </div>
                <div class="col-md-6 col-12"></div>
                <div class="col-md-6 col-12">
                  <div><p>Region</p></div>
                  <q-select
                    dense
                    v-model="form.region"
                    outlined
                    option-value="id"
                    option-label="name_region"
                    map-options
                    emit-value
                    lazy-rules
                    :options="regions"
                    :loading="loading_region"
                    @update:model-value="
                      (value) => onSelectRegion(value, 'region_id')
                    "
                  />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>Sub-Region</p></div>
                  <q-select
                    dense
                    v-model="form.sub_region"
                    outlined
                    :loading="loading_region"
                    :disable="loading_region"
                    option-value="id"
                    option-label="name_sub_region"
                    map-options
                    emit-value
                    :options="sub_regions"
                  />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>Organisasi</p></div>
                  <q-select
                    dense
                    :options="organisasis"
                    v-model="form.organisasi_id"
                    option-value="id"
                    option-label="nama_organisasi"
                    map-options
                    emit-value
                    outlined
                  />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>Jabatan</p></div>
                  <q-select dense v-model="form.jabatan" outlined readonly />
                </div>
                <div class="col-md-6 col-12">
                  <div><p>Jenis</p></div>
                  <q-select dense v-model="form.jenis" outlined readonly />
                </div>
              </div>
            </q-card-section>
            <!-- Relawan -->
            <!-- <q-card-section>
                            <template
                                v-for="(relawan, index) in FormRelawan"
                                :key="index"
                            >
                                <q-badge>Relawan : {{ index + 1 }} </q-badge>
                                <div class="row q-col-gutter-md">
                                    <div class="col-md-2 col-6">
                                        <q-select
                                            :options="users"
                                            v-model="relawan.nik"
                                            dense
                                            use-input
                                            outlined
                                            option-value="id"
                                            option-label="nik"
                                            label="NIK"
                                            @update:model-value="
                                                (val) =>
                                                    onSelectAnggota(
                                                        val,
                                                        relawan
                                                    )
                                            "
                                        />
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <q-select
                                            :options="users"
                                            v-model="relawan.nama"
                                            use-input
                                            dense
                                            outlined
                                            option-value="id"
                                            option-label="name"
                                            label="Nama "
                                            @update:model-value="
                                                (val) =>
                                                    onSelectAnggota(
                                                        val,
                                                        relawan
                                                    )
                                            "
                                        />
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <q-btn
                                            color="red"
                                            icon="delete"
                                            dense
                                            @click="
                                                onDeleteRelawan(relawan, index)
                                            "
                                        />
                                    </div>
                                </div>
                            </template>
                        </q-card-section> -->

            <!-- <q-card-section>
                            <div class="row q-mt-md">
                                <q-space />
                                <div class="col-auto q-mb-md q-mr-sm">
                                    <q-btn
                                        @click="onAddRelawans"
                                        style="max-width: 300px"
                                        color="indigo-12"
                                        icon="add"
                                        type="submit"
                                        :loading="loading"
                                    />
                                </div>
                            </div>
                        </q-card-section> -->

            <div class="row q-col-gutter-md q-mb-md">
              <q-space />
              <div class="col-mb-6">
                <q-btn
                  @click="visit('/data/korlap')"
                  class="q-mr-md"
                  style="max-width: 300px"
                  color="red-6"
                  icon="cancel"
                  label="Cancel"
                />
              </div>

              <div class="col-mb-5">
                <q-btn
                  style="max-width: 300px"
                  color="light-green-5"
                  icon="save"
                  label="Simpan"
                  type="submit"
                  :loading="loading"
                />
              </div>
            </div>
          </div>
        </q-card-section>
      </q-card>
    </q-form>
  </q-page>
</template>
<script setup>
import { Inertia } from "@inertiajs/inertia";
import { reactive, ref, watch } from "vue";
import { formatDate } from "@/plugins/utils";

const props = defineProps([
  "organisasis",
  "users",
  "prov",
  "kab",
  "kec",
  "desa",
  "regions",
  "sub_regions",
]);
const loading = ref(false);
const loading_region = ref(false);
const loading_wilayah = ref(false);

const form = reactive({
  nama: "",
  nik: "",
  nohp: "",
  provinsi: "",
  kabupaten: "",
  kecamatan: "",
  desa: "",
  alamat: "",
  organisasi_id: "",
  jabatan: "",
  jenis: "",
  user_id: null,
  desa_id: null,
  region: null,
  sub_region: null,
  user: null,
});

const onSelectUser = (val) => {
  console.log(val);
  form.nik = val.nik;
  form.nama = val.name;
  form.user_id = val.id;
  form.nohp = val.phone;
  form.provinsi = val.provinsi;
  form.kabupaten = val.kabupaten;
  form.kecamatan = val.kecamatan;
  form.desa = val.desa;
  form.desa_id = val.desa_id;
  form.rt = val.rt;
  form.rw = val.rw;
  form.alamat = val.address;
  form.jenis = val.jenis?.name;
  form.region = val.region?.name_region;
  form.organisasi_id = val.organisasi?.id;
  form.jabatan = val.jabatan?.nama_jabatan;
  form.sub_region = val.sub_region?.name_sub_region;

  onSelect(val.provinsi, "prov_id", () => {
    onSelect(val.kabupaten, "kab_id", () => {
      onSelect(val.kecamatan, "kec_id", () => {});
    });
  });
};

const onSelectAnggota = (val, relawan) => {
  relawan.nama = val.name;
  relawan.nik = val.nik;
};
// add and remove
const onAddRelawans = () => {
  FormRelawan.value.push({
    nik: "",
    nama: "",
  });
};
const onDeleteRelawan = (relawan, i) => {
  const index = FormRelawan.value.indexOf(relawan);
  if (index > -1) {
    FormRelawan.value.splice(index, 1);
  }
};
// input search
const options = ref(props.users);
const filterFn = (val, update, abort) => {
  update(() => {
    const needle = val.toLowerCase();
    options.value = props.users.filter(
      (v) => v.name.toLowerCase().indexOf(needle) > -1
    );
  });
};
// select input
const onSelect = (value, key, callback = null) => {
  console.log(key, value);
  loading_wilayah.value = true;
  if (key == "prov_id") {
    form.kabupaten = null;
    form.kecamatan = null;
    form.desa = null;
  } else if (key == "kab_id") {
    form.kecamatan = null;
    form.desa = null;
  } else if (key == "kec_id") {
    form.desa = null;
  }

  Inertia.get(
    "/data/korlap/create",
    {
      prov_id: form.provinsi,
      kab_id: form.kabupaten,
      kec_id: form.kecamatan,
      ...{ [key]: value },
    },
    {
      onFinish: () => {
        loading_wilayah.value = false;

        if (typeof callback === "function") {
          callback();
        }
      },
      preserveState: true,
      preserveScroll: true,
    }
  );
};

const onSelectRegion = (region_id) => {
  form.sub_region = null;
  loading_region.value = true;
  Inertia.get(
    "/data/korlap/create",
    {
      region_id,
    },
    {
      onFinish: () => {
        loading_region.value = false;
      },
      preserveState: true,
      preserveScroll: true,
    }
  );
};
// submit
const onSubmit = () => {
  Inertia.post("/data/korlap", form, {
    onFinish: () => {
      loading.value = false;
    },
  });
};
// remove

const visit = (path) => {
  Inertia.visit(path);
};
</script>

<style lang="scss" scoped></style>
