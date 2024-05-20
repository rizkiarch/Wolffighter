<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6">Edit Data Relawan</div>
            </q-card-section>

            <q-form @submit="onSubmit">
                <q-card-section>
                    <div class="row q-col-gutter-sm">
                        <div class="col-md-6 col-12">
                            <div><p>NO</p></div>
                            <q-input
                                dense
                                v-model="users.no"
                                outlined
                                option-value="id"
                                option-label="name"
                                map-options
                                emit-value
                                readonly
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Jenis</p></div>
                            <q-select
                                dense
                                v-model="users.jenis.name"
                                :options="jenis"
                                outlined
                                option-value="id"
                                option-label="name"
                                map-options
                                emit-value
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Nama</p></div>
                            <q-input
                                dense
                                outlined
                                lazy-rules
                                v-model="users.name"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>NIK</p></div>
                            <q-input
                                dense
                                outlined
                                type="number"
                                lazy-rules
                                v-model="users.nik"
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
                                v-model="users.jk"
                                :options="options"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>No HP</p></div>
                            <q-input
                                dense
                                outlined
                                type="number"
                                lazy-rules
                                v-model="users.phone"
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
                                v-model="users.provinsi"
                                :options="prov"
                                outlined
                                option-value="kode"
                                option-label="nama"
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
                                v-model="users.kabupaten"
                                :options="kab"
                                outlined
                                option-value="kode"
                                option-label="nama"
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
                                v-model="users.kecamatan"
                                :options="kec"
                                outlined
                                option-value="kode"
                                option-label="nama"
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
                                v-model="users.desa"
                                :options="desa"
                                outlined
                                option-value="kode"
                                option-label="nama"
                                map-options
                                emit-value
                            />
                        </div>
                        <div class="col-md-3 col-6">
                            <div><p>RT</p></div>
                            <q-input
                                dense
                                outlined
                                map-options
                                emit-value
                                lazy-rules
                                v-model="users.rt"
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
                                outlined
                                map-options
                                emit-value
                                lazy-rules
                                v-model="users.rw"
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
                                outlined
                                map-options
                                emit-value
                                v-model="users.address"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Region</p></div>
                            <q-select
                                dense
                                :options="regions"
                                outlined
                                option-value="id"
                                option-label="name_region"
                                map-options
                                emit-value
                                v-model="users.region.name_region"
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Sub-Region</p></div>
                            <q-select
                                dense
                                v-model="users.sub_region.name_sub_region"
                                :options="subregions"
                                outlined
                                option-value="id"
                                option-label="name_sub_region"
                                map-options
                                emit-value
                            />
                        </div>
                        <div class="col-md-6 col-12">
                            <div><p>Organisasi</p></div>
                            <q-select
                                dense
                                :options="organisasis"
                                outlined
                                option-value="id"
                                option-label="nama_organisasi"
                                map-options
                                emit-value
                                v-model="users.organisasi.nama_organisasi"
                            />
                        </div>
                        <div class="col-md-5 col-10">
                            <div><p>Jabatan</p></div>
                            <q-select
                                dense
                                :options="jabatan"
                                outlined
                                option-value="id"
                                option-label="nama_jabatan"
                                map-options
                                emit-value
                                v-model="users.jabatan.nama_jabatan"
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
import { reactive, ref } from "vue";

const { relawan } = defineProps([
    "users",
    "jenis",
    "jabatan",
    "organisasis",
    "subregions",
    "regions",

    "prov",
    "kab",
    "kec",
    "desa",
]);

const options = ref(["Laki-Laki", "Perempuan"]);

const loading = ref(false);

const onSelect = (value, key) => {
    Inertia.get(
        `/data/relawan/${relawan.id}`,
        {
            prov_id: users.provinsi,
            kab_id: users.kabupaten,
            kec_id: users.kecamatan,
            ...{ [key]: value },
        },
        // { kab_id: value },
        // { kec_id: value },
        // { desa_id: value },
        {
            onFinish: () => {
                loading.value = false;
            },
            preserveState: true,
            preserveScroll: true,
        }
    );
};
// const onSelect = (value) => {
//     Inertia.get(
//         `/data/relawan/${relawan.id}`,
//         {
//             // _method: "put",
//             ...relawan,
//         },
//         {
//             onFinish: () => {
//                 loading.value = false;
//             },
//             preserveState: true,
//             preserveScroll: true,
//         }
//     );
// };

const onSubmit = () => {
    console.log(relawan);
    Inertia.put(
        `/data/relawan/${relawan.id}`,
        {
            _method: "put",
            ...relawan,
        },
        {
            onFinish: () => {
                loading.value = false;
            },
        }
    );
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
