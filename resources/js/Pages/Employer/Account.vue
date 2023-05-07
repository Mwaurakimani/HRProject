<script setup>
import {Link, router, useForm} from '@inertiajs/vue3';
import MobileInfluencerDashboardLayout from "../../Layouts/MobileInfluencerDashboardLayout.vue";
import MobileDashboardHeader from '../../Components/MobilOnlyComponents/MobileDashboardHeader.vue';

import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';
import AccountSummaryVue from './Components/AccountSummary.vue';
import EditAccountVue from './Components/EditAccount.vue';
import SocialMediaVue from './Components/SocialMedia.vue';
import {authStore} from "../../Store/AuthStore";
import {storeToRefs} from "pinia";
import {inject, onBeforeMount, ref, useAttrs} from "vue";
import authenticate from "../Shared/authenticate";
import MarketerAboutCard from "../../Components/Shared/MarketerAboutCard.vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    user: Object,
    marketer: Object,
    company: Object
});

authenticate();

const auth = authStore();
const authenticated = ref(false);
const currentUser = inject('currentUser');

if (currentUser == null || currentUser == 'undefined'){
    window.location.href = window.location.href
}



</script>

<template>
    <teleport to="body">
        <MobileInfluencerDashboardLayout :activePage="'Account'">
        </MobileInfluencerDashboardLayout>
    </teleport>
    <MobileDashboardHeader class="mb-[10px]" :title="'Account'"/>
    <div class="intro mb-[20px]">
        <p class="p2 mb-[5px] " style="text-align: center"> {{ props.user.first_name }}  {{ props.user.last_name }}</p>
        <div class="h-[25px] flex items-center justify-center" style="width: fit-content">
            <div class="star-icon w-[100%] h-[100%] p-[3px]">
                <img style="max-width: 20px;max-height: 20px" src="/storage/icons8-star-100.png">
            </div>
            <p class="pt-[3px]" >4.5</p>
        </div>
        <!--        TODO::add status-->
        <p class="p3 mb-[5px] " style="text-align: center;color: var(--light-green)">Available</p>
        <Link :href="'editAccount'" as="span" class="icon w-[30px] h-[30px] p-[5px] ">
            <img src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-pencil-64.png">
        </Link>
    </div>
    <MarketerAboutCard :user.camel="props.user" class="w-[95%] mx-[auto] mt-[10px] mb-[20px]"></MarketerAboutCard>
</template>

<style lang="scss" scoped>
@import "../sassLoader";

.intro {
    width: 90%;
    margin: auto;
    margin-bottom: 20px;
    height: 100px;
    display: grid;
    grid-template-columns: 1fr 40px;
    grid-template-rows: 1fr 1fr 1fr;
    grid-template-areas:
    "name edit"
    "rating edit"
    "status edit";

    p:nth-of-type(1) {
        text-align: left;
        width: fit-content;
        grid-area: name;
    }

    p:nth-of-type(2) {
        text-align: left;
        width: fit-content;
        grid-area: status;
    }

    div{
        grid-area: rating;
    }

    span{
        grid-area: edit;
    }
}

</style>
