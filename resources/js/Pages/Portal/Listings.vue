<script  setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import {Link} from '@inertiajs/vue3'




provide('activeSideNavigationLink','Users')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'Listings'">
        </PageTitle>
        <div class="flex justify-between mb-[30px] p-[10px]" >
            <section >
                <ul class="flex" style="gap: 10px">
                    <li>Available Jobs 20</li>
                    <li>|</li>
                    <li>Applied Jobs 20</li>
                </ul>
            </section>
            <section>
                <Link as="button" :href="route('CreateJob')">Create a Job Opening</Link>
            </section>
        </div>
        <div class="container flex flex-wrap" style="justify-content: space-around;gap:15px;">
            <div v-for="job in jobs"  class="card-shadowed w-[300px]  h-[330px] p-[15px] bg-white">
                <h5 class="mb-[15px]">{{job.Title}}</h5>
                <p class="mb-[20px]">{{ job.Description }}</p>
                <Link as="button" :href="route('ViewListing',[job.id])">View</Link>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
export default {
    props:['users','tag','jobs']
}
</script>

<style lang="scss" scoped >
@import "./theme";

.card-shadowed{
    button{
        display: block;
        margin: auto;
        background-color: dodgerblue;
        color: white;
        padding: 5px 20px;
    }
}
</style>




