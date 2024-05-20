<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6">Create Organisasi</div>
            </q-card-section>

            <q-form @submit="onSubmit">
                <q-card-section>
                    <div class="q-col-gutter-sm q-mb-md">
                        <div class="row q-col-gutter-sm">
                            <div class="col-md-6 col-12">
                                <div><p>Sub-Region</p></div>
                                <q-select
                                    v-model="form.sub_region_id"
                                    :options="subregions"
                                    label="Sub-Region"
                                    outlined
                                    dense
                                    option-value="id"
                                    option-label="name_sub_region"
                                    map-options
                                    emit-value
                                />
                            </div>
                            <div class="col-md-6 col-12">
                                <div><p>Nama Organisasi</p></div>
                                <q-input
                                    outlined
                                    v-model="form.nama_organisasi"
                                    type="text"
                                    label="Nama Organisasi"
                                    dense
                                    lazy-rules
                                    :rules="[
                                        (val) =>
                                            (val && val.length > 0) ||
                                            'Please type Nama Organisasi',
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
                            <div class="col-md-6 col-12">
                                <div><p>Alamat Organisasi</p></div>
                                <q-input
                                    outlined
                                    v-model="form.alamat_organisasi"
                                    type="text"
                                    label="Alamat Organisasi"
                                    dense
                                />
                            </div>

                            <q-space />
                            <div class="col-md-2 col-6 q-mt-xl">
                                <q-btn
                                    color="primary"
                                    icon="save"
                                    label="Save"
                                    class="full-width"
                                    type="submit"
                                    :loading="loading"
                                />
                            </div>
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

defineProps(["subregions", "organisasi", "prov", "kab", "kec", "desa"]);

const loading = ref(false);
const loading_wilayah = ref(false);

const form = reactive({
    sub_region_id: "",
    nama_organisasi: "",
    provinsi: "",
    kabupaten: "",
    kecamatan: "",
    desa: "",
    alamat_organisasi: "",
});

// const onSelect = (value, key) => {
//     Inertia.get(
//         "/data/organisasi/create",
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
        "/data/organisasi/create",
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
    Inertia.post("/data/organisasi", form, {
        onFinish: () => {
            loading.value = false;
        },
    });
};
</script>

<style lang="scss" scoped></style>
