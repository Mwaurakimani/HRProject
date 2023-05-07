<script setup>
import {counterStore} from '../../Store/stores';
import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';
import InfluencerCard from '../../Components/InfluencerCard.vue';
import ProjectCard from '../../Components/ProjectsCard.vue';
import {router} from "@inertiajs/vue3";
import {authStore} from "../../Store/AuthStore";
import {storeToRefs} from "pinia";
import {inject} from "vue";
import MobileInfluencerDashboardLayout from "../../Layouts/MobileInfluencerDashboardLayout.vue";
import MobileDashboardHeader from '../../Components/MobilOnlyComponents/MobileDashboardHeader.vue';
import PaginationComponent from "../../Components/Shared/PaginationComponent.vue";
import MobileProjectDisplayCard from '../../Components/MobilOnlyComponents/MobileProjectDisplayCard.vue'
import {Link} from "@inertiajs/vue3";


const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    projects: Object
});

const currentUser = inject('currentUser');
const auth = authStore()
if (currentUser != null) {
    auth.authenticate()
}
const {status, user} = storeToRefs(auth)

function createProject(){
    router.visit(route('createProject'))
}


</script>

<template>
    <teleport to="body">
        <MobileInfluencerDashboardLayout :activePage="'Projects'">
        </MobileInfluencerDashboardLayout>
    </teleport>
    <MobileDashboardHeader :title="'Projects'"/>
    <header class="h-[60px] flex items-center justify-between px-[10px]">
        <p v-if="props.projects && props.projects.length > 0" class="p3 text-grey-100 ">{{ props.projects.length }} projects found</p>
        <div class="icon-holder flex items-center justify-center flex-wrap ml-[auto] ">
            <img class="w-[50px] h-[50px]" src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-configuration-67.png"
                 alt="">
            <div @click.prevent="createProject">
                <img @click.prevent="" class="w-[30px] h-[30px]"
                     src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-add-new-100.png" alt="">
            </div>
        </div>
    </header>

    <div  v-if="props.projects && props.projects.length > 0" class="content-area">
        <div class="mobile-content-area">
            <div class="container mb-[30px] " v-for="project in props.projects">
                <MobileProjectDisplayCard :project="project" :link="'ViewOwnedProject'"></MobileProjectDisplayCard>
            </div>
            <div class="container flex justify-center items-center">
                <pagination-component class="mb-[100px]"></pagination-component>
            </div>
        </div>
    </div>
    <div v-else class="w-[90%] mx-[auto] h-[100px] flex" style="align-items: center;justify-content: center"  >
        <h5>No Projects Found..</h5>
    </div>

</template>

<style lang="scss" scoped>
@import "../sassLoader";

header {
    .icon-holder{
        z-index: 500;
    }
}
</style>
