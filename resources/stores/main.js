import { defineStore } from "pinia";

export const useMainStore = defineStore("main", {
    state: () => {
        return {
            drawer: false,
            loadingVisit: false,
        };
    },
    actions: {
        setDrawer(value) {
            this.drawer = value;
        },
        setLoadingVisit(value) {
            this.loadingVisit = value;
        },
    },
    persist: true,
});
