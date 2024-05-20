// https://pinia.vuejs.org/introduction.html#basic-example

import { defineStore } from "pinia";

export const useCounterStore = defineStore("counter", {
    state: () => {
        return { count: 0 };
    },
    getters: {
        getCount: (state) => state.count,
    },
    actions: {
        increment() {
            this.count++;
        },
    },
    persist: true,
});
