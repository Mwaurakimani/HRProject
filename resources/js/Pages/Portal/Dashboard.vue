<script  setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";

const props = defineProps({
});

provide('activeSideNavigationLink','dashboard')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'Dashboard'">
        </PageTitle>
    </AdminLayout>
</template>

