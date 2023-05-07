<script setup>

import {Link} from "@inertiajs/vue3";

const props = defineProps([
    'activePage',
])



</script>

<template>
    <div class="mobile-menu">
        <a href="/" class="icon-holder">
            <img v-if="props.activePage == 'Home'" src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-home-page-96.png">
            <img v-else src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-home-page-96-grey.png">
        </a>
        <Link :href="route('Account')" class="icon-holder">
            <img v-if="props.activePage == 'Account'" src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-user-100.png">
            <img v-else src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-user-100-grey.png">
        </Link>
        <Link :href="route('MyProjects')" class="icon-holder">
            <img v-if="props.activePage == 'Projects'" src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-test-passed-100.png">
            <img v-else src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-project-100-grey.png">
        </Link>
        <Link :href="route('Notifications')" class="icon-holder">
            <img v-if="props.activePage == 'Notifications'" src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-alarm-100.png">
            <img v-else src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-alarm-100-grey.png">
        </Link>
        <Link :href="route('Finance')" class="icon-holder">
            <img v-if="props.activePage == 'Finance'" src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-coins-96.png">
            <img v-else src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-coins-96-grey.png">
        </Link>
    </div>
</template>
<style lang="scss" scoped>
@import './../../Pages/sassLoader';

.mobile-menu{
    height: 60px;
    width: 100%;
    display: flex;
    box-shadow: 0px -3px 4px #eeeeee;
    justify-content: space-around;

    .icon-holder{
        padding: 10px;

        img{
            max-width: 100%;
            max-height: 100%;
        }
    }
}

@include s-screens {

}
</style>
