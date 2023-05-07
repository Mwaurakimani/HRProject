<script  setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import PaginationSection from "@PortalComponent/PaginationSection.vue";
import {Link} from "@inertiajs/vue3";



const props = defineProps({
});

provide('activeSideNavigationLink','Finance')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'Finance'">
            <div class=" flex action-tab" style="gap: 5px" >
                <Link as="button" :href="'/dashboard'">Stats</Link>
                <Link as="button" :href="'/dashboard'">Transfers</Link>
                <Link as="button" :href="route('AdminListDeposits')">Deposits</Link>
                <Link as="button" :href="route('AdminListWithdraws')">Withdraws</Link>
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
            <div style="margin-left: auto" class="h-[42px] w-[150px] flex gap-1 justify-end "  >
                <button>Add New</button>
            </div>
        </section>
        <section class="display-filter  mb-[10px]">
            <ul class="flex">
                <li>Admin</li>
                <li>Active</li>
                <li>Peter Kimani</li>
            </ul>
        </section>
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
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
            </tr>
            </tbody>
        </table>
        <PaginationSection/>
    </AdminLayout>
</template>
<style lang="scss" scoped >
@import "theme";

tbody{
    tr{
        height: 50px !important;
    }
}
</style>




