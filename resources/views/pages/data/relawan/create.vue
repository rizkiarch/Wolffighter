<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6">Buat Data Relawan</div>
            </q-card-section>

            <q-form @submit="onSubmit">
                <q-card-section>
                    <div class="row q-col-gutter-sm">
                        <div class="col-md-6 col-12">
                            <div><p>Jenis</p></div>
                            <q-select
                                dense
                                v-model="form.jenis_id"
                                :options="jenis"
                                outlined
                                option-value="id"
                                option-label="name"
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) ||
                                        'Jenis harus dipilih',
                                ]"
                            />
                        </div>

                        <div class="col-md-6 col-12" v-if="form.jenis_id != 2">
                            <div><p>Korlap</p></div>
                            <q-select
                                dense
                                v-model="form.korlap_id"
                                :options="korlaps"
                                outlined
                                option-value="id"
                                option-label="nama"
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) ||
                                        'Korlap harus dipilih',
                                ]"
                            />
                        </div>

                        <div class="col-md-6 col-12">
                            <div><p>Nama</p></div>
                            <q-input
                                dense
                                v-model="form.name"
                                outlined
                                lazy-rules
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>NIK</p></div>
                            <q-input
                                dense
                                v-model="form.nik"
                                outlined
                                type="number"
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) || 'Please type NIK',
                                ]"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Jenis Kelamin</p></div>
                            <q-select
                                dense
                                transition-show="scale"
                                transition-hide="scale"
                                outlined
                                v-model="form.jk"
                                :options="options"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>No HP</p></div>
                            <q-input
                                dense
                                v-model="form.phone"
                                outlined
                                type="number"
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) || 'Please type No HP',
                                ]"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Provinsi</p></div>
                            <q-select
                                @update:model-value="
                                    (value) => onSelect(value, 'prov_id')
                                "
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
                                @update:model-value="
                                    (value) => onSelect(value, 'kab_id')
                                "
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
                                @update:model-value="
                                    (value) => onSelect(value, 'kec_id')
                                "
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
                                @update:model-value="
                                    (value) => onSelect(value, 'desa_id')
                                "
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
                            <div><p>RT</p></div>
                            <q-input
                                dense
                                v-model="form.rt"
                                outlined
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val.length > 0) ||
                                        'Please type RT.',
                                ]"
                            />
                        </div>
                        <div class="col-md-3 col-6">
                            <div><p>RW</p></div>
                            <q-input
                                dense
                                v-model="form.rw"
                                outlined
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) || 'Please type RW.',
                                ]"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Alamat</p></div>
                            <q-input
                                dense
                                v-model="form.address"
                                outlined
                                option-value="id"
                                option-label="name"
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val.length > 0) ||
                                        'Please type Alamat',
                                ]"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Region</p></div>
                            <q-select
                                dense
                                v-model="form.region_id"
                                :options="regions"
                                outlined
                                option-value="id"
                                option-label="name_region"
                                :loading="loading_region"
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) ||
                                        'Please type Organisasi',
                                ]"
                                @update:model-value="
                                    (value) =>
                                        onSelectRegion(value, 'region_id')
                                "
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Sub-Region</p></div>
                            <q-select
                                dense
                                v-model="form.sub_region_id"
                                :options="subregions"
                                outlined
                                option-value="id"
                                option-label="name_sub_region"
                                :loading="loading_region"
                                :disable="loading_region"
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) ||
                                        'Please type Organisasi',
                                ]"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Organisasi</p></div>
                            <q-select
                                dense
                                v-model="form.organisasi_id"
                                :options="organisasis"
                                outlined
                                option-value="id"
                                option-label="nama_organisasi"
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) ||
                                        'Please type Organisasi',
                                ]"
                            />
                        </div>
                        <div class="col-md-5 col-10">
                            <div><p>Jabatan</p></div>
                            <q-select
                                dense
                                v-model="form.jabatan_id"
                                :options="jabatan"
                                outlined
                                option-value="id"
                                option-label="nama_jabatan"
                                map-options
                                emit-value
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val > 0) ||
                                        'Please type Jabatan',
                                ]"
                            />
                        </div>
                        <div class="col-md-1 col-1">
                            <div style="opacity: 0"><p>Jabatan</p></div>

                            <q-btn
                                round
                                color="green"
                                @click="prompt"
                                icon="add"
                            >
                            </q-btn>
                        </div>
                    </div>
                    <div class="row q-col-gutter-md q-mt-md">
                        <q-space />
                        <div class="col-mb-6">
                            <q-btn
                                @click="visit('/data/relawan/index')"
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
                </q-card-section>
            </q-form>
        </q-card>
    </q-page>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { Dialog } from "quasar";
import { reactive, ref } from "vue";

defineProps([
    "regions",
    "subregions",
    "organisasis",
    "jabatan",
    "jenis",
    "prov",
    "kab",
    "kec",
    "desa",
    "korlaps",
]);

// select
const options = ref(["Laki-Laki", "Perempuan"]);

const loading = ref(false);
const loading_region = ref(false);
const loading_wilayah = ref(false);

const form = reactive({
    jenis_id: "",
    korlap_id: null,
    name: "",
    nik: "",
    jk: "",
    phone: "",
    provinsi: "",
    kabupaten: "",
    kecamatan: "",
    desa: "",
    rt: "",
    rw: "",
    address: "",
    organisasi_id: "",
    jabatan_id: "",
    region_id: "",
    sub_region_id: "",
});

const onSelectRegion = (region_id) => {
    form.sub_region_id = null;
    loading_region.value = true;
    Inertia.get(
        "/data/relawan/create",
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

// const onSelect = (value, key) => {
//     Inertia.get(
//         "/data/relawan/create",
//         {
//             prov_id: form.provinsi,
//             kab_id: form.kabupaten,
//             kec_id: form.kecamatan,
//             ...{ [key]: value },
//         },
//         // { kab_id: value },
//         // { kec_id: value },
//         // { desa_id: value },
//         {
//             onFinish: () => {
//                 loading.value = false;
//             },
//             preserveState: true,
//             preserveScroll: true,
//         }
//     );
// };
// select input
const onSelect = (value, key, callback = null) => {
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
        "/data/relawan/create",
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

const onSubmit = () => {
    Inertia.post("/data/relawan", form, {
        onFinish: () => {
            loading.value = false;
        },
    });
};

function prompt() {
    Dialog.create({
        title: "Tambah Jabatan",
        message: "Nama Jabatan",
        prompt: {
            model: "",
            type: "text", // optional
        },
        cancel: true,
        persistent: true,
    })
        .onOk((data) => {
            console.log(">>>> OK, received", data);
        })
        .onCancel(() => {
            console.log(">>>> Cancel");
        })
        .onDismiss(() => {
            console.log("I am triggered on both OK and Cancel");
        });
}
</script>

<style lang="scss" scoped></style>
