<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <q-card-section class="row">
                    <div class="text-h6 col-auto">Sub Region</div>
                    <q-space />

                    <div>
                        <q-btn
                            color="primary"
                            icon="add"
                            label="Region"
                            @click="visit('/data/sub-region/create')"
                        />
                    </div>
                </q-card-section>
                <div class="row q-col-gutter-md q-mb-lg">
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

                    <!-- <div class="col-md-3 col-12">
                        <q-select
                            v-model="customer_id"
                            id="customer_id"
                            :options="customers"
                            track-by="id"
                            emit-value
                            @update:model-value="onFilter"
                            map-options
                            option-label="name"
                            option-value="id"
                            :loading="loading"
                            label="Organisasi"
                            debounce="600"
                            filled
                            dense
                            clearable
                        >
                            <template v-slot:no-option>
                                <q-item>
                                    <q-item-section class="text-grey">
                                        No results
                                    </q-item-section>
                                </q-item>
                            </template>
                        </q-select>
                    </div> -->
                </div>

                <q-card-section>
                    <q-table
                        :rows="subregions"
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
                                                `/data/sub-region/${props.row.id}/edit`
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
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";

defineProps(["subregions"]);

const loading = ref(false);

const onDelete = ({ row }) => {
    Inertia.delete(`/data/sub-region/${row.id}`);
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
        name: "region",
        field: "region",
        label: "Region",
        align: "left",
        sortable: true,
        format: (val) => val.name_region,
    },
    {
        name: "name_sub_region",
        field: "name_sub_region",
        label: "Nama",
        align: "left",
        sortable: true,
    },

    {
        name: "button",
        label: "Action",
        align: "left",
    },
];
const search = ref(null);
const onFilter = () => {
    Inertia.get(
        "/data/sub-region",
        {
            search: search.value,
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
