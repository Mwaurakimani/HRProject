<script  setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import PaginationSection from "@PortalComponent/PaginationSection.vue";
import {Link} from '@inertiajs/vue3'




provide('activeSideNavigationLink','Users')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="tag?tag:'User'">
            <div class=" flex action-tab" style="gap: 5px">
                <Link as="button" :href="route('AdminUsers',['Influencers'])" >Influencer</Link>
                <Link as="button" :href="route('AdminUsers',['Marketers'])" >Marketer</Link>
                <Link as="button" :href="route('AdminUsers',['Moderators'])" >Moderator</Link>
            </div>
        </PageTitle>
        <section class="manipulation-tab mb-[15px] flex">
            <div>
                <input type="search" placeholder="Search by Name">
            </div>
            <div>
                <input type="search" placeholder="Search by ID">
            </div>
            <div>
                <input type="search" placeholder="Search by Code">
            </div>
            <div>
                <select>
                    <option>All</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Suspended</option>
                </select>
            </div>
            <div style="margin-left: auto" class="h-[42px] w-[150px] flex gap-1 justify-end ">
                <Link as="button" :href="route('AdminAddUser')">Add New</Link>
            </div>
        </section>
<!--        <section class="display-filter  mb-[10px]">-->
<!--            <ul class="flex">-->
<!--                <li>Admin</li>-->
<!--                <li>Active</li>-->
<!--                <li>Peter Kimani</li>-->
<!--            </ul>-->
<!--        </section>-->
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Designation</th>
            </tr>
            </thead>
            <tbody>
            <Link as="tr" :href="route('AdminViewUser',[user.id])" v-for="(user,index) in users">
                <th scope="row">{{ index + 1 }}</th>
                <td>{{ user.first_name }} {{ user.last_name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone }}</td>
                <td v-if="user.influencer">Influencer</td>
                <td v-else-if="user.marketer" >Marketer</td>
                <td v-else="user.marketer" >{{ user.designation }}</td>
            </Link>
            </tbody>
        </table>
<!--        <PaginationSection/>-->
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




