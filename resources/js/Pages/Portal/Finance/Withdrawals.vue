<script  setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import PaginationSection from "@PortalComponent/PaginationSection.vue";
import { Link } from "@inertiajs/vue3"



const props = defineProps(['Withdraws']);

provide('activeSideNavigationLink','Finance')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'Deposits'">
            <div class=" flex action-tab" style="gap: 5px" >
                <Link as="button" :href="'/dashboard'">Stats</Link>
                <Link as="button" :href="'/dashboard'">Transfers</Link>
                <Link as="button" :href="route('AdminListDeposits')">Deposits</Link>
                <Link as="button" :href="route('AdminListWithdraws')">Withdraws</Link>
            </div>
        </PageTitle>
        <section class="manipulation-tab mb-[15px] flex">
<!--            <div>-->
<!--                <input type="search" placeholder="Search by Name">-->
<!--            </div>-->
<!--            <div>-->
<!--                <input type="search" placeholder="Search by ID">-->
<!--            </div>-->
<!--            <div>-->
<!--                <input type="search" placeholder="Search by Code">-->
<!--            </div>-->
<!--            <div>-->
<!--                <select>-->
<!--                    <option>All</option>-->
<!--                    <option>Active</option>-->
<!--                    <option>Inactive</option>-->
<!--                    <option>Suspended</option>-->
<!--                </select>-->
<!--            </div>-->
<!--            <div style="margin-left: auto" class="h-[42px] w-[150px] flex gap-1 justify-end "  >-->
<!--                <button>Add New</button>-->
<!--            </div>-->
        </section>
        <section class="display-filter  mb-[10px]">
<!--            <ul class="flex">-->
<!--                <li>Admin</li>-->
<!--                <li>Active</li>-->
<!--                <li>Peter Kimani</li>-->
<!--            </ul>-->
        </section>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Agent</th>
                <th scope="col">User</th>
                <th scope="col">Amount (Ksh)</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
            <Link as="tr" :href="route('AdminViewWithdrawal',[Withdraws.id])" v-for="Withdraws in props.Withdraws">
                <th scope="row">{{ Withdraws.id }}</th>
                <td>{{Withdraws.agent.first_name}} {{Withdraws.agent.last_name}}</td>
                <td>{{Withdraws.user.first_name}} {{Withdraws.user.last_name}}</td>
                <td>{{ Withdraws.amount }}</td>
                <td>{{ Withdraws.status }}</td>
            </Link>
            </tbody>
        </table>
<!--        <PaginationSection/>-->
    </AdminLayout>
</template>
<style lang="scss" scoped >
@import "../theme";

tbody{
    tr{
        height: 50px !important;
    }
}
</style>




