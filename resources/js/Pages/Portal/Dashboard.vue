<script  setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {provide} from "vue";

const props = defineProps({
});

provide('activeSideNavigationLink','dashboard')

</script>

<template>
    <AdminLayout>
    </AdminLayout>
</template>

