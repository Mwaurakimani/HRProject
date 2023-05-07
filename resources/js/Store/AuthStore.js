import {defineStore} from "pinia";
import route from "ziggy-js/src/js";

export const authStore = defineStore('authenticationStore', {
    state: () => ({
        status: false,
        user: null,
        confirmed: false
    })
    ,
    getters: {
        getUSer() {
            return this.user
        },
        isAuthenticated() {
            return this.status
        },
    },

    actions: {
        unAuthenticate() {
            this.status = false
            this.user = null
        },
        authenticate(payload) {
            this.status = true
            this.user = payload
        },
        testIfLoggedIn() {
            try {
                const resp = axios.post(route('routeIsLoggedIn'))
                return resp
            } catch (error) {
                // Handle any errors here
                console.error(error)
            }
        }

    }
})
