// https://pinia.vuejs.org/introduction.html#basic-example

import { defineStore } from "pinia";

export const usePoDetail = defineStore("counter", {
    state: () => {
        return {
            number: 0,
            input: [{
                kode: '',
                barang: '',
                satuan: '',
                qty: '',
                harga: '',
                diskon: '',
                total: '',
            }, {
                kode: '',
                barang: '',
                satuan: '',
                qty: '',
                harga: '',
                diskon: '',
                total: '',
            }]
        };
    },
    getters: {
        getNumber: (state) => state.number,
        getKode: (state) => state.kode,
    },
    actions: {
        increment() {
            this.input.push({
                kode: '',
                barang: '',
                satuan: '',
                qty: '',
                harga: '',
                diskon: '',
                total: '',
            });
            this.number++;
            console.log(this.input);

        },
        decrement() {
            this.number--;
        },
    },
    // persist: true,
});
