<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6">Edit Region</div>
            </q-card-section>

            <q-form @submit="onSubmit">
                <q-card-section>
                    <div class="q-col-gutter-md doc-container q-mb-md">
                        <div class="row q-col-gutter-md">
                            <div class="col-md-6 col-12">
                                <q-input
                                    v-model="region.no"
                                    type="text"
                                    label="Code"
                                    outlined
                                    dense
                                    disable
                                />
                            </div>

                            <div class="col-md-6 col-12">
                                <q-input
                                    v-model="region.name_region"
                                    type="text"
                                    label="Name"
                                    outlined
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

const { region } = defineProps(["region"]);

const loading = ref(false);

const onSelect = (value) => {
    form.group_id = null;
    Inertia.get(
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
        `/data/region/${region.id}`,
        {
            _method: "put",
            ...region,
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
