<script setup>
import { counterStore } from '../Store/stores';
import { storeToRefs } from 'pinia';
import MobileNavigationComponent from '../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../Components/DesktopNavigation.vue';
import InfluencerCard from '../Components/InfluencerCard.vue';
import ProjectCard from '../Components/ProjectsCard.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

</script>

<template>
    <nav>
        <MobileNavigationComponent :activeNavButton="'AboutUs'"></MobileNavigationComponent>
        <DesktopNavigationVue :activeNavButton="'AboutUs'"></DesktopNavigationVue>
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
