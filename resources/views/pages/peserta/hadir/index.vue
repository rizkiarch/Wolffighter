<template layout>
    <q-page padding>
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6">Kehadiran</div>
            </q-card-section>

            <q-card-actions align="left">
                <q-btn
                    label="Camera"
                    color="primary"
                    icon="photo_camera"
                    @click="openCamera"
                />
            </q-card-actions>

            <q-separator />
            <q-table flat dense :rows="data" :columns="columns" row-key="id" />
        </q-card>

        <q-dialog v-model="camera" persistent @hide="stopScanner">
            <q-card style="width: 400px; max-width: 80vw">
                <q-card-section class="row items-center q-py-sm">
                    <div class="text-h6">Scanner Kehadiran</div>
                    <q-space />
                    <q-btn icon="close" flat round dense v-close-popup />
                </q-card-section>

                <q-separator />

                <q-card-section
                    class="scroll text-center"
                    style="max-height: 400px"
                >
                    <video id="qr-video" width="350" height="300"></video>
                </q-card-section>

                <q-separator />

                <q-card-actions align="right">
                    <q-btn
                        dense
                        flat
                        color="primary"
                        icon="flip_camera_ios"
                        @click="flipCamera"
                    >
                        <q-tooltip> Putar Kamera </q-tooltip>
                    </q-btn>

                    <!-- <q-btn dense flat color="primary" icon="flash_on">
                        <q-tooltip> Flash </q-tooltip>
                    </q-btn> -->
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<script setup>
import QrScanner from "qr-scanner";
import { formatDate } from "@/plugins/utils";
import { beep } from "@/plugins/audio";
import { nextTick, onBeforeUnmount, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

defineProps(["data"]);

const camera = ref(false);
const hasFlash = ref(false);
const hasCamera = ref(false);
const scanner = ref(null);
const videoElem = ref(null);
const cameras = ref([]);
const cameraSelected = ref(0);

const columns = [
    {
        name: "user",
        field: "user",
        label: "NAMA ANGGOTA",
        align: "left",
        sortable: true,
        format: (val) => val.name,
    },
    {
        name: "check_in",
        field: "check_in",
        label: "MASUK",
        align: "left",
        sortable: true,
        format: (val) => formatDate(val, "DD/MM/YYYY HH:mm"),
    },
    {
        name: "user",
        field: "user",
        label: "ORGANISASI",
        align: "left",
        sortable: true,
        format: (val) => val?.organisasi?.nama_organisasi,
    },

    {
        name: "user",
        field: "user",
        label: "JABATAN",
        align: "left",
        sortable: true,
        format: (val) => val?.jabatan?.nama_jabatan,
    },

    {
        name: "user",
        field: "user",
        label: "KECAMATAN",
        align: "left",
        sortable: true,
        format: (val) => val?.wilayah?.detail?.name,
    },
];

const onScanned = (result) => {
    Inertia.post(
        "/peserta/hadir/scan",
        {
            user_id: result.data,
        },
        {
            preserveScroll: true,
            preserveState: true,
            onFinish: () => {
                beep();
            },
        }
    );
};

const print = () => {};

const stopScanner = () => {
    scanner.value.stop();
};

const flipCamera = () => {
    if (cameras.value.length > 1) {
        if (cameras.value[1].id === cameraSelected.value.id) {
            cameraSelected.value = cameras.value[0];
        } else {
            cameraSelected.value = cameras.value[1];
        }

        scanner.value.setCamera(cameraSelected.value.id);
    }
};

const openCamera = () => {
    camera.value = true;
    nextTick(() => {
        videoElem.value = document.getElementById("qr-video");

        scanner.value = new QrScanner(videoElem.value, onScanned, {
            maxScansPerSecond: 1,
            highlightScanRegion: true,
            highlightCodeOutline: true,
        });

        const updateFlashAvailability = () => {
            scanner.value.hasFlash().then((result) => {
                hasFlash.value = result;
            });
        };

        scanner.value.start().then(() => {
            updateFlashAvailability();

            QrScanner.listCameras(true).then((result) => {
                if (result.length > 0) {
                    cameraSelected.value = result[0];
                }

                cameras.value = result;
            });
        });

        QrScanner.hasCamera().then((result) => {
            hasCamera.value = result;
        });
    });
};

onBeforeUnmount(() => {
    if (scanner.value) {
        scanner.value.stop();
    }
});
</script>

<style lang="scss" scoped></style>
