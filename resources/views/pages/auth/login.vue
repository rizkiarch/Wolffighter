<template layout="AuthLayout">
    <q-page class="row flex flex-center q-px-md">
        <div class="col-md-4 col-xs-12">
            <q-card>
                <q-card-section>
                    <div class="text-h6">Login</div>
                </q-card-section>

                <!-- <q-separator /> -->

                <q-form
                    @submit="doLogin"
                    autocorrect="off"
                    autocapitalize="off"
                    autocomplete="off"
                    spellcheck="false"
                >
                    <q-card-section>
                        <div class="q-gutter-sm">
                            <q-input
                                v-model="form.username"
                                label="User Name"
                                type="text"
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val.length > 0) ||
                                        'Username is required',
                                ]"
                            ></q-input>
                            <q-input
                                v-model="form.password"
                                type="password"
                                label="Password"
                                lazy-rules
                                :rules="[
                                    (val) =>
                                        (val && val.length > 0) ||
                                        'Password is required',
                                ]"
                            ></q-input>
                        </div>
                    </q-card-section>

                    <q-card-section>
                        <q-btn
                            color="primary"
                            class="full-width"
                            label="Login"
                            :loading="loading"
                            type="submit"
                        ></q-btn>
                    </q-card-section>
                </q-form>
            </q-card>
        </div>
    </q-page>
</template>

<script setup>
import { reactive, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const loading = ref(false);

const form = reactive({
    username: "",
    password: "",
});

const doLogin = () => {
    loading.value = true;
    Inertia.post("/auth/login", form, {
        onFinish: () => {
            loading.value = false;
        },
    });
};
</script>

<style lang="scss" scoped></style>
