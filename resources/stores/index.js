import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

/**
 * @see https://pinia.vuejs.org/getting-started.html
 */
const pinia = createPinia();

/**
 * @see https://github.com/prazdevs/pinia-plugin-persistedstate
 */
pinia.use(piniaPluginPersistedstate);

export default pinia;
