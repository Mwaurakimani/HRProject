import { defineStore } from "pinia";
import { ref } from "vue";

export const counterStore = defineStore('counter', {
    state() {
        return {
            count: 0
        }
    },
    actions: {
        increment() {
            if (this.count < 10)
                this.count++
        },
        decrement() {
            if(this.count > 0)
            this.count--
        }
    }
})