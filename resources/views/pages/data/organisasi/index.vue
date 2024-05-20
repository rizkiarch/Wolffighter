<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <q-card-section class="row">
                    <div class="text-h6 col-auto">Organisasi</div>
                    <q-space />

                    <div>
                        <q-btn
                            color="primary"
                            icon="add"
                            label="Organisasi"
                            @click="visit('/data/organisasi/create')"
                        />
                    </div>
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
                </div>
                <q-card class="form q-mb-md">
                    <q-card-section>
                        <q-table
                            :rows="organisasis"
                            :columns="columns"
                            row-key="id"
                            flat
                        >
                            <template v-slot:body-cell-button="props">
                                <q-td :props="props">
                                    <div class="q-gutter-sm">
                                        <q-btn
                                            dense
                                            size="sm"
                                            color="info"
                                            icon="edit"
                                            @click="
                                                visit(
                                                    `/data/organisasi/${props.row.id}/edit`
                                                )
                                            "
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

const props = defineProps(["organisasis", "organisasis.subregion"]);
const loading = ref(false);

const onDelete = ({ row }) => {
    Inertia.delete(`/data/organisasi/${row.id}`);
};

const onUpdate = (key, value, { row }) => {
    Inertia.put(`/data-master/category/${row.category_id}`, { key, value });
};

const visit = (path) => {
    Inertia.visit(path);
};

const columns = [
    {
        name: "no",
        field: "no",
        label: "No",
        align: "left",
        sortable: true,
    },
    {
        name: "sub_region",
        field: "sub_region",
        label: "Nama Sub-Region",
        align: "left",
        sortable: true,
        format: (val) => val?.name_sub_region,
    },

    {
        name: "nama_organisasi",
        field: "nama_organisasi",
        label: "Nama Organisasi",
        align: "left",
        sortable: true,
    },

    {
        name: "alamat_organisasi",
        field: "alamat_organisasi",
        label: "Alamat",
        align: "left",
        sortable: true,
    },

    {
        name: "button",
        label: "Action",
        align: "left",
    },
];

// search

const options = ref(props.organisasis);
const organisasi_id = ref(null);
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
        "/data/organisasi",
        {
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
</script>

<style lang="scss" scoped></style>
