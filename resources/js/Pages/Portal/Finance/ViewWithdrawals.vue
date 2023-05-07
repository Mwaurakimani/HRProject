<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import {Link} from '@inertiajs/vue3'


const props = defineProps(['withdraw']);

provide('activeSideNavigationLink', 'Finance')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'View Withdrawal'">
            <div class=" flex action-tab" style="gap: 5px" >
                <Link as="button" :href="'/dashboard'">Stats</Link>
                <Link as="button" :href="'/dashboard'">Transfers</Link>
                <Link as="button" :href="route('AdminListDeposits')">Deposits</Link>
                <Link as="button" :href="route('AdminListWithdraws')">Withdraws</Link>
            </div>
        </PageTitle>
        <section class="manipulation-tab mb-[15px] flex">
            <div style="margin-left: auto" class="h-[42px] w-[250px] flex gap-1 justify-end">
                <button @click.prevent="saveUser">Update</button>
            </div>
        </section>
        <section class="content">
            <div class="w-[65%]">
                <form @submit.prevent="">
                    <h5 class="text-grey-300 mb-[10px]">User Details</h5>
                    <div style="gap: 20px 5px;" class="flex flex-wrap justify-between">
                        <div class="flex w-[49%]" style="flex-direction: column">
                            <label>Agent Name</label>
                            <input disabled class="w-[100%]" type="text" placeholder="First Name" v-model="Withdraw.agent">
                        </div>
                        <div class="flex w-[49%]" style="flex-direction: column">
                            <label>User Name</label>
                            <input disabled class="w-[100%]" type="text" placeholder="First Name" v-model="Withdraw.client">
                        </div>
                        <div class="flex w-[49%]" style="flex-direction: column">
                            <label>Phone Number</label>
                            <input disabled class="w-[100%]" type="text" placeholder="First Name" v-model="Withdraw.phone">
                        </div>
                        <div class="flex w-[49%]" style="flex-direction: column">
                            <label>Transaction Code</label>
                            <input disabled class="w-[100%]" type="text" placeholder="First Name" v-model="Withdraw.transaction_code">
                        </div>
                        <div class="flex w-[100%]" style="flex-direction: column">
                            <label>Amount</label>
                            <input disabled class="w-[100%]" type="text" placeholder="First Name" v-model="Withdraw.amount">
                        </div>
                        <div class="flex w-[100%]" style="flex-direction: column">
                            <label>Status</label>
                            <select class="w-[100%]"  v-model="Withdraw.status">
                                <option value="Unprocessed">Unprocessed</option>
                                <option value="Canceled">Canceled</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="w-[35%]">
                <form @submit.prevent="">
                    <h5 class="text-grey-300 mb-[10px]">Notes</h5>
                    <div style="gap: 20px 5px;" class="flex flex-wrap justify-between">
                        <div class="flex w-[100%]" style="flex-direction: column">
                            <textarea class="w-[100%] h-[300px]" v-model="Withdraw.notes"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </AdminLayout>
</template>

<script>
import {useForm} from "@inertiajs/vue3";

export default {
    data() {
        return {
            Withdraw: useForm({
                agent:this.withdraw.agent.first_name+' '+this.withdraw.agent.last_name,
                client:this.withdraw.user.first_name+' '+this.withdraw.user.last_name,
                phone:this.withdraw.phone,
                transaction_code:this.withdraw.transaction_code,
                amount:this.withdraw.amount,
                status:this.withdraw.status,
                notes:this.withdraw.notes
            })
        }
    },
    methods: {
        saveUser() {
            axios.post(route('AdminUpdateTransaction',[this.withdraw.id,'withdrawal']),this.Withdraw)
                .then((resp) =>{
                    alert(resp.data.message);
                }).catch((err) =>{
                alert(resp.data.message);
            })
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../theme";

tbody {
    tr {
        height: 50px !important;
    }
}

.content {
    width: 100%;
    margin: auto;
    height: 600px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

</style>




