<script setup>
import { counterStore } from '../Store/stores';
import { storeToRefs } from 'pinia';
import MobileNavigationComponent from '../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../Components/DesktopNavigation.vue';
import InfluencerCard from '../Components/InfluencerCard.vue';
import ProjectCard from '../Components/ProjectsCard.vue';
import {inject} from "vue";
import {authStore} from "../Store/AuthStore";

const currentUser = inject('currentUser');
const auth = authStore()
if (currentUser != null) {
    auth.authenticate()
}
const {status, user} = storeToRefs(auth)

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

</script>

<template>
    <nav>
        <MobileNavigationComponent :activeNavButton="'ContactUs'"></MobileNavigationComponent>
        <DesktopNavigationVue :activeNavButton="'ContactUs'"></DesktopNavigationVue>
    </nav>
    <footer>

    </footer>

</template>

<style lang="scss" scoped>

@media only screen and (min-width: 980px) {
}
@media only screen and (min-width: 849px) {
}
</style>
