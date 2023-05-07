<script setup>
import MobileDashboardNavigationComponent from '../Components/MobilOnlyComponents/MobileDashboardNavigationComponent.vue';

const props = defineProps([
    'activePage'
])
</script>


<template>
    <div class="mobile-menu">
        <MobileDashboardNavigationComponent :activePage="activePage"></MobileDashboardNavigationComponent>
    </div>
</template>

<script>
export default {
    name: "MobileInfluencerDashboardLayout"
}
</script>

<style lang="scss" scoped>
@import '../Pages/sassLoader';
body{
}

.mobile-menu{
    background-color: white;
    position: fixed;
    bottom: 0px;
}

</style>
