import { defineConfig } from "vite";
import laravel from "vite-plugin-laravel";
import vue from "@vitejs/plugin-vue";
import { quasar, transformAssetUrls } from "@quasar/vite-plugin";
import inertia from "./resources/scripts/vite/inertia-layout";
import pwaConfig from "./resources/scripts/pwa.conf";
import { VitePWA } from "vite-plugin-pwa";

export default defineConfig({
    plugins: [
        VitePWA(pwaConfig),
        inertia(),
        vue({
            template: { transformAssetUrls },
        }),
        quasar({
            sassVariables: "resources/css/quasar-variables.scss",
        }),
        laravel(),
    ],
});
