<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import {Link} from '@inertiajs/vue3'


const props = defineProps({});

provide('activeSideNavigationLink', 'Users')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'Add User'">
            <div class=" flex action-tab" style="gap: 5px">
                <Link as="button" :href="route('AdminUsers',['Influencers'])" >Influencer</Link>
                <Link as="button" :href="route('AdminUsers',['Marketers'])" >Marketer</Link>
                <Link as="button" :href="route('AdminUsers',['Moderators'])" >Moderator</Link>
            </div>
        </PageTitle>
        <section class="manipulation-tab mb-[15px] flex">
            <div style="margin-left: auto" class="h-[42px] w-[250px] flex gap-1 justify-end">
                <button @click.prevent="saveUser">Save</button>
                <Link as="button" :href="route('AdminAddUser')">Add New</Link>
            </div>
        </section>
        <section class="content">
            <div class="w-[65%]">
                <form @submit.prevent="" class="mb-[20px]">
                    <h5 class="text-grey-300 mb-[10px]">User Details</h5>
                    <div style="gap: 20px 5px;" class="flex flex-wrap justify-between">
                        <input class="w-[49%]" type="text" placeholder="First Name" v-model="userForm.first_name" >
                        <input class="w-[49%]" type="text" placeholder="Last Name" v-model="userForm.last_name" >
                        <input class="w-[100%]" type="text" placeholder="Email" v-model="userForm.email" >
                        <select class="w-[15%]" style="">
                            <option value="+254">+254</option>
                        </select  >
                        <input class="w-[84%]" type="text" placeholder="Phone" v-model="userForm.phone" >
                        <select class="w-[100%]" style=""  v-model="userForm.designation" >
                            <option value=""></option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                </form>

            </div>
            <div class="w-[35%]">

            </div>
        </section>
    </AdminLayout>
</template>

<script>
import {useForm} from "@inertiajs/vue3";

export default {
    data() {
        return {
            userForm: useForm({
                first_name: null,
                last_name: null,
                email: null,
                phone: null,
                designation: null,
            })
        }
    },
    methods: {
        saveUser() {
            axios.post(route('CreateUser'),this.userForm)
                .then((resp) =>{
                console.log(resp);
            }).catch((err) =>{
                console.log(err)
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




