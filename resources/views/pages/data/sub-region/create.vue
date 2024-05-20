<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6">Create Sub-Region</div>
            </q-card-section>

            <q-form @submit="onSubmit">
                <q-card-section>
                    <div class="q-col-gutter-md doc-container q-mb-md">
                        <div class="row q-col-gutter-md">
                            <div class="col-md-6 col-12">
                                <q-select
                                    v-model="form.region_id"
                                    :options="regions"
                                    label="Region"
                                    outlined
                                    dense
                                    option-value="id"
                                    option-label="name_region"
                                    map-options
                                    emit-value
                                />
                            </div>
                            <div class="col-md-6 col-12">
                                <q-input
                                    outlined
                                    v-model="form.name_sub_region"
                                    type="text"
                                    label="Nama Region"
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

defineProps(["regions"]);

const loading = ref(false);
const form = reactive({
    name_sub_region: "",
    region_id: null,
});

const onSubmit = () => {
    Inertia.post("/data/sub-region", form, {
        onFinish: () => {
            loading.value = false;
        },
    });
};
</script>

<style lang="scss" scoped></style>
