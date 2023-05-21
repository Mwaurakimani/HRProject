<script  setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import {Link} from '@inertiajs/vue3'




provide('activeSideNavigationLink','Users')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'Applications'">
        </PageTitle>
    </AdminLayout>
</template>

<script>
export default {
    props:['users','tag']
}
</script>

<style lang="scss" scoped >
@import "./theme";

tbody{
    tr{
        height: 50px !important;
    }
}
</style>




