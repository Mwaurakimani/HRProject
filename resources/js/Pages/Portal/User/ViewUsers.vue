<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import {Link} from '@inertiajs/vue3'

provide('activeSideNavigationLink', 'Users')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'View User'">
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
                        <input class="w-[49%]" type="text" placeholder="First Name" v-model="userForm.first_name">
                        <input class="w-[49%]" type="text" placeholder="Last Name" v-model="userForm.last_name">
                        <input class="w-[100%]" type="text" placeholder="Email" v-model="userForm.email">
                        <select class="w-[15%]" style="">
                            <option value="+254">+254</option>
                        </select>
                        <input class="w-[84%]" type="text" placeholder="Phone" v-model="userForm.phone">
                        <select class="w-[100%]" style="" v-model="userForm.designation">
                            <option value=""></option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                </form>
                <div v-if="user.influencer" class="panel">
                    <h5 class="text-grey-300 mb-[20px]">Influencer Details</h5>
                    <div class="mb-[50px]">
                        <h6>Bio</h6>
                        <p>{{ user.influencer.bio }}</p>
                        <div>
                        </div>
                    </div>
                    <ul>
                        <h6 class="text-grey-300 mb-[20px]">Social Accounts</h6>
                        <li v-for="(account,index) in user.social_account "  class="social_display_card">
                            <div>
                                <label for="">Platform</label>
                                <p>{{ account.platform.name }}</p>
                            </div>
                            <div>
                                <label for="">Username</label>
                                <p>{{ account.username }}</p>
                            </div>
                            <div>
                                <label for="">Class</label>
                                <p>{{ account.influencer_class.name }}</p>
                            </div>
                            <div>
                                <label for="">Minimum Subscribers</label>
                                <p>{{ account.influencer_class.min_count }}</p>
                            </div>
                            <div>
                                <label for="">Maximum Subscribers</label>
                                <p>{{ account.influencer_class.max_count }}</p>
                            </div>
                            <div>
                                <label for="">Status</label>
                                <select v-model="account.status" >
                                    <option value="verified">Verified</option>
                                    <option value="unverified">Unverified</option>
                                </select>
                            </div>
                            <div>
                                <button @click.prevent="updateSocialAccountStatus(account.id)" >Update</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-[35%]">

            </div>
        </section>
    </AdminLayout>
</template>

<script>
import {useForm} from "@inertiajs/vue3";

export default {
    props: ['user'],
    data() {
        return {
            userForm: useForm({
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                email: this.user.email,
                phone: this.user.phone,
                designation: this.user.designation,
            })
        }
    },
    methods: {
        saveUser() {
            axios.post(route('CreateUser'), this.userForm)
                .then((resp) => {
                    console.log(resp);
                }).catch((err) => {
                console.log(err)
            })
        },
        updateSocialAccountStatus(id){
            let status = $(event.currentTarget).parent().parent().find('select').val();

            axios.post(route('updateSocialAccountStatus',[id]), {status:status})
                .then((resp) => {
                    alert(resp.data.message)
                    window.location.href = window.location.href
                }).catch((err) => {
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

.social_display_card {
    width: 100%;
    display: grid;
    margin-bottom: 10px;
    height: 150px;
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(2, 70px);
    grid-template-areas:
    "platform username influencerclass minCount maxCount"
    "status action action action action";
    border-bottom: 1px solid lightgrey;

    div:nth-of-type(1) {
        grid-area: platform;
    }

    div:nth-of-type(2) {
        grid-area: username;
    }

    div:nth-of-type(3) {
        grid-area: influencerclass;
    }

    div:nth-of-type(4) {
        grid-area: minCount;
    }

    div:nth-of-type(5) {
        grid-area: maxCount;
    }

    div:nth-of-type(6) {
        grid-area: status;
    }

    div:nth-of-type(7) {
        grid-area: action;
        display: flex;
        align-items: center;
    }

    div {
        label {
            width: 100%;
            height: 30px;
            line-height: 30px;
            color: dodgerblue;
        }
        select{
            height: auto;
            width: 150px;
            padding: 5px 20px;
        }

    }

}

</style>




