<template>
    <div class="panel-holder">
        <SideNavigation class="SideNavigation"/>
        <TopNavigation class="TopNavigation"/>
        <ContentArea class="ContentArea">
            <slot></slot>
        </ContentArea>
    </div>
</template>
<script>
import SideNavigation from "./SideNavigation.vue";
import TopNavigation from "./TopNavigation.vue";
import ContentArea from "./ContentArea.vue";

export default {
    name: 'AdminLayout',
    components: {ContentArea, TopNavigation, SideNavigation}
}
</script>

<style lang="scss">
@import "./../Pages/sassLoader";

.panel-holder {
    display: grid;
    grid-template-columns: 200px 1fr;
    grid-template-rows: 50px 1fr;
    width: 100vw;
    gap: 3px;
    height: 100vh;
    background-color: #f3f3f3;
    overflow: hidden;
    grid-template-areas:
        "SideNav TopBar"
        "SideNav content";
}

.SideNavigation {
    grid-area: SideNav;
}

.TopNavigation {
    grid-area: TopBar;
    position: sticky;
    top: 0px;
}

.ContentArea {
    grid-area: content;
    overflow-y: auto;
}
</style>
