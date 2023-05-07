<script setup>
import {Link, router, useForm} from '@inertiajs/vue3';
import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';
import {onMounted, ref} from "vue";


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

const employerForm = useForm({
    'first_name': "Marketer",
    'last_name': "One",
    'email': "marketerone@gmail.com",
    'phone': "0700000002",
    'password': "password",
    'account_type':'single',
    'confirm_password': "password",
    'brand_name': null
})

function createEmployer() {
    axios.post(route('createUser',['Marketer']), employerForm)
        .then((resp) => {
            if (resp.data.status) {
                router.visit('login')
            }
        })
}

const activePanel = ref('Account');

function moveTo(payload) {
    activePanel.value = payload
}

</script>

<template>
    <nav>
        <MobileNavigationComponent :activeNavButton="'Projects'"></MobileNavigationComponent>
        <DesktopNavigationVue :activeNavButton="'Projects'"></DesktopNavigationVue>
    </nav>
    <header>
        <div class="modile-header">
            <div class="container">
                <section>
                    <h4 class="pt-[13px]" style="color: var(--t-purple)">Join The Marketers Community</h4>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area">
        <div v-if="activePanel === 'Account'" class="container">
            <p class="p3 p-[20px]  mb-[20px]" style="text-align: center">Lorem ipsum dolor sit amet consectetur,
                adipisicing elit. Odit
                asperiores ea neque quae eaque possimus vel amet quisquam fugiat sequi repudiandae ex, perferendis minus
                illum. Sit autem nesciunt totam deserunt!</p>
            <form class="card-shadowed mb-[50px] w-[100%] " action="" @submit.prevent="submit">
                <h6 class="p-[15px] mb-[20px]  text-center">Join The Influencer Community</h6>
                <div class="form-content">
                    <section>
                        <div class="input-group">
                            <label for="">First Name</label>
                            <input type="text" v-model="employerForm.first_name">
<!--                            <span class="error span-3 py-[10px] text-red-500">Error</span>-->
                        </div>
                        <div class="input-group">
                            <label for="">Last Name</label>
                            <input type="text" v-model="employerForm.last_name">
<!--                            <span class="error span-3 py-[10px] text-red-500">Error</span>-->
                        </div>
                        <div class="input-group">
                            <label for="">Email</label>
                            <input type="email" v-model="employerForm.email">
<!--                            <span class="error span-3 py-[10px] text-red-500">Error</span>-->
                        </div>
                        <div class="input-group">
                            <label for="">Phone</label>
                            <input type="tel" v-model="employerForm.phone">
<!--                            <span class="error span-3 py-[10px] text-red-500">Error</span>-->
                        </div>
<!--                        <div class="input-group">-->
<!--                            <label for="">Brand Name</label>-->
<!--                            <input type="email" v-model="employerForm.brand_name">-->
<!--                            <span class="error span-3 py-[10px] text-red-500">Error</span>-->
<!--                        </div>-->
                        <div class="input-group">
                            <label for="">Password</label>
                            <input type="password" v-model="employerForm.password">
<!--                            <span class="error span-3 py-[10px] text-red-500">Error</span>-->
                        </div>
                        <div class="input-group">
                            <label for="">Confirm Password</label>
                            <input type="password" v-model="employerForm.confirm_password">
<!--                            <span class="error  span-3 py-[10px] text-red-500">Error</span>-->
                        </div>
                    </section>
                </div>
                <div class="button-section flex justify-end p-[20px]">
                    <button @click.prevent="createEmployer" class="purple">Register</button>
                </div>
            </form>
        </div>
    </div>
    <footer>

    </footer>
</template>

<style lang="scss" scoped>
@import "../sassLoader";
</style>
