divdivdiv
<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6">Edit Organisasi</div>
            </q-card-section>

            <q-form @submit="onSubmit">
                <q-card-section>
                    <div class="q-col-gutter-md doc-container q-mb-md">
                        <div class="row q-col-gutter-md">
                            <div class="col-md-6 col-12">
                                <q-input
                                    v-model="organisasi.no"
                                    type="text"
                                    label="Code"
                                    outlined
                                    dense
                                    disable
                                />
                            </div>
                            <div class="col-md-6 col-12">
                                <q-select
                                    v-model="organisasi.sub_region_id"
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
                                <q-input
                                    v-model="organisasi.nama_organisasi"
                                    type="text"
                                    label="Name"
                                    outlined
                                    dense
                                />
                            </div>

                            <div class="col-md-6 col-12">
                                <q-select
                                    @update:model-value="
                                        (value) => onSelect(value, 'prov_id')
                                    "
                                    dense
                                    v-model="organisasi.provinsi"
                                    :options="prov"
                                    outlined
                                    option-value="kode"
                                    option-label="nama"
                                    map-options
                                    emit-value
                                />
                            </div>
                            <div class="col-md-6 col-12">
                                <q-select
                                    @update:model-value="
                                        (value) => onSelect(value, 'kab_id')
                                    "
                                    dense
                                    :disable="!organisasi.provinsi"
                                    v-model="organisasi.kabupaten"
                                    :options="kab"
                                    outlined
                                    option-value="kode"
                                    option-label="nama"
                                    map-options
                                    emit-value
                                />
                            </div>
                            <div class="col-md-6 col-12">
                                <q-select
                                    @update:model-value="
                                        (value) => onSelect(value, 'kec_id')
                                    "
                                    dense
                                    :disable="!organisasi.kabupaten"
                                    v-model="organisasi.kecamatan"
                                    :options="kec"
                                    outlined
                                    option-value="kode"
                                    option-label="nama"
                                    map-options
                                    emit-value
                                />
                            </div>
                            <div class="col-md-6 col-12">
                                <q-select
                                    @update:model-value="
                                        (value) => onSelect(value, 'desa_id')
                                    "
                                    dense
                                    :disable="!organisasi.kecamatan"
                                    v-model="organisasi.desa"
                                    :options="desa"
                                    outlined
                                    option-value="kode"
                                    option-label="nama"
                                    map-options
                                    emit-value
                                />
                            </div>
                            <div class="col-md-6 col-12">
                                <q-input
                                    outlined
                                    v-model="organisasi.alamat_organisasi"
                                    type="text"
                                    label="Alamat Organisasi"
                                    dense
                                />
                            </div>

                            <q-space />

                            <div class="col-md-2 col-6 q-gutter-xl">
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

const { organisasi } = defineProps([
    "organisasi",
    "subregions",
    "prov",
    "kab",
    "kec",
    "desa",
]);

const loading = ref(false);
const onSelectUser = (val, organisasi) => {
    onSelect(val.provinsi, "prov_id", () => {
        onSelect(val.kabupaten, "kab_id", () => {
            onSelect(val.kecamatan, "kec_id", () => {});
        });
    });
};
const onSelect = (value) => {
    Inertia.put(
        `/data/organisasi/${organisasi.id}`,
        {
            // _method: "put",
            ...organisasi,
        },
        {
            onFinish: () => {
                loading.value = false;
            },
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const onSubmit = () => {
    Inertia.post(
        `/data/organisasi/${organisasi.id}`,
        {
            _method: "put",
            ...organisasi,
        },
        {
            onFinish: () => {
                loading.value = false;
            },
        }
    );
};

const counterLabelFn = ({ totalSize }) => {
    return totalSize;
};
</script>

<style lang="scss" scoped></style>
