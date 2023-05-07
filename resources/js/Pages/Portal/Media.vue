<script  setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {provide} from "vue";

const props = defineProps({
});

provide('activeSideNavigationLink','Media')

</script>

<template>
    <AdminLayout>
        <h4 class="text-grey-300">Media</h4>
    </AdminLayout>
</template>

