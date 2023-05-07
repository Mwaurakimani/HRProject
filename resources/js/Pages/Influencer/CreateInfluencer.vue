<script setup>
import {Link, router, useForm} from '@inertiajs/vue3';
import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';
import {inject, reactive, ref} from "vue";
import {authStore} from "../../Store/AuthStore";
import {storeToRefs} from "pinia";
import MobileInfleuncerModifySocialAccountsComponent
    from "../../Components/MobilOnlyComponents/MobileInfleuncerModifySocialAccountsComponent.vue";


const currentUser = inject('currentUser');
const auth = authStore()
if (currentUser != null) {
    auth.authenticate()
}
const {status, user} = storeToRefs(auth)

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

const influencerForm = useForm({
    'first_name': "Mwaura",
    'last_name': "Kimani",
    'email': "mwaura@gmail.com",
    'phone': "0700000001",
    'password': "password",
    'password_confirmation': "password",
    'bio': "This is my main account",
    'social_account': {
        facebook: {
            username: "mwaurakimani_fb",
            influencerClass: "Nano-Influencer",
            // platformDetail: {
            //     'Cover Photo': {
            //         status: false,
            //         unit: "hr",
            //         value: 1000,
            //         options: [
            //             'hr',
            //             'day',
            //             'week'
            //         ]
            //     },
            //     post: {
            //         status: false,
            //         value: 0
            //     },
            //     timeline: {
            //         status: false,
            //         value: 0
            //     },
            //     stories: {
            //         status: false,
            //         value: 0
            //     },
            //     reels: {
            //         status: false,
            //         unit: null,
            //         value: 0,
            //         options: [
            //             'hr',
            //             'day',
            //             'week'
            //         ]
            //     },
            // },
        },
        twitter: {
            username: "mwaurakimani_tw",
            influencerClass: "Nano-Influencer",
            // platformDetail: {
            //     post: {
            //         status: false,
            //         value: 0
            //     },
            //     timeline: {
            //         status: false,
            //         value: 0
            //     },
            // },
        },
        instagram: {
            username: "mwaurakimani_ig",
            influencerClass: "Nano-Influencer",
            // platformDetail: {
            //     post: {
            //         status: false,
            //         value: 0
            //     },
            //     stories: {
            //         status: false,
            //         value: 0
            //     },
            // },
        },
        tiktok: {
            username: "mwaurakimani_tiktok",
            influencerClass: "Nano-Influencer",
            // platformDetail: {
            //     post: {
            //         status: false,
            //         value: 0
            //     },
            // },
        }
    },
})

const activePanel = ref('Account');
const errors = reactive({
    status: false,
    errors: {}
});

function moveTo(payload) {
    influencerForm.check = payload
    axios.post(route('createInfluencerValidate'), influencerForm)
        .then((resp) => {
            if (resp.data.status) {
                errors.errors = {}
                errors.status = false;
                activePanel.value = payload
            }
        }).catch((err) => {
        if (err.response.status === 422) {
            errors.errors = err.response.data.errors;
            errors.status = true;
        } else {
            errors.errors = {}
            errors.status = false;
        }
    })
}

function validate(payload) {
    console.log(payload)
}

function submit() {

    axios.post(route('createUser',['Influencer']), influencerForm)
        .then((resp) => {
            if (resp.data.status) {
                errors.errors = {}
                errors.status = false;
                activePanel.value = 'Finish'
            } else {
                alert("Sorry. Something went wrong...")
                // alert(resp.data.message)
            }
        }).catch((err) => {
        alert("Error creating Account")
    })
}

function debounce(func, wait) {
    let timer;
    return function (...args) {
        if (timer) {
            clearTimeout(timer); // clear any pre-existing timer
        }
        const context = this; // get the current context
        timer = setTimeout(() => {
            fn.apply(context, args); // call the function if time expires
        }, wait);
    }
}

function keyCount() {
    console.log("hi")
}

const categories = reactive([])
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
                    <h4 class="pt-[13px]" style="color: var(--t-purple)">Join The Influencer Community</h4>
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
                            <input type="text" v-model="influencerForm.first_name">
                            <span v-if="errors.errors && errors.errors.first_name"
                                  class="error span-3 py-[10px] text-red-500">{{ errors.errors.first_name[0] }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Last Name</label>
                            <input type="text" v-model="influencerForm.last_name">
                            <span v-if="errors.errors && errors.errors.last_name"
                                  class="error span-3 py-[10px] text-red-500">{{ errors.errors.last_name[0] }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Email</label>
                            <input type="email" v-model="influencerForm.email">
                            <span v-if="errors.errors && errors.errors.email"
                                  class="error span-3 py-[10px] text-red-500">{{ errors.errors.email[0] }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Phone</label>
                            <input type="tel" v-model="influencerForm.phone">
                            <span v-if="errors.errors && errors.errors.phone"
                                  class="error span-3 py-[10px] text-red-500">{{ errors.errors.phone[0] }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Password</label>
                            <input type="password" v-model="influencerForm.password">
                            <span v-if="errors.errors && errors.errors.password"
                                  class="error span-3 py-[10px] text-red-500">{{ errors.errors.password[0] }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Confirm Password</label>
                            <input type="password" v-model="influencerForm.password_confirmation">
                            <span v-if="errors.errors && errors.errors.password_confirmation"
                                  class="error span-3 py-[10px] text-red-500">{{
                                    errors.errors.password_confirmation [0]
                                }}</span>
                        </div>
                    </section>
                </div>
                <div class="button-section flex justify-end p-[20px]">
                    <button @click.prevent="moveTo('SocialAccounts')" class="purple" type="submit">Social Accounts
                    </button>
                </div>
            </form>
        </div>
        <div v-if="activePanel === 'SocialAccounts'" class="container">
            <p class="p3 p-[20px]  mb-[20px]" style="text-align: center">Lorem ipsum dolor sit amet consectetur,
                adipisicing elit. Odit
                asperiores ea neque quae eaque possimus vel amet quisquam fugiat sequi repudiandae ex, perferendis minus
                illum. Sit autem nesciunt totam deserunt!</p>
            <form class="card-shadowed mb-[50px] w-[100%] " action="" @submit.prevent="submit">
                <h6 class="p-[15px] mb-[20px]  text-center">Add social accounts</h6>
                <div class="form-content ">
                    <MobileInfleuncerModifySocialAccountsComponent :supportedPlatforms="influencerForm"
                                                                   class="w-[100%]"></MobileInfleuncerModifySocialAccountsComponent>
                </div>
                <div class="button-section flex justify-between p-[20px]">
                    <button @click.prevent="moveTo('Account')" class="purple" type="submit">Account</button>
                    <button @click.prevent="moveTo('Bio')" class="purple" type="submit">Bio</button>
                </div>
            </form>
        </div>
        <div v-if="activePanel === 'Bio'" class="container">
            <p class="p3 p-[20px]  mb-[20px]" style="text-align: center">Lorem ipsum dolor sit amet consectetur,
                adipisicing elit. Odit
                asperiores ea neque quae eaque possimus vel amet quisquam fugiat sequi repudiandae ex, perferendis minus
                illum. Sit autem nesciunt totam deserunt!</p>
            <form class="card-shadowed mb-[50px] w-[100%] " action="" @submit.prevent="submit">
                <h6 class="p-[15px] mb-[20px]  text-center">Bio</h6>
                <div class="form-content">
                    <textarea class="w-[100%] h-[200px]" @keyup="debounce(keyCount,300)" v-model="influencerForm.bio">

                    </textarea>
                    <span class="span-2 text-grey-200 ">0/500</span>
                </div>
                <div class="button-section flex justify-between p-[20px]">
                    <button @click.prevent="moveTo('SocialAccounts')" class="purple" type="submit">Social Accounts
                    </button>
                    <button @click.prevent="moveTo('Categories')" class="purple" type="submit">Categories</button>
                </div>
            </form>
        </div>
        <div v-if="activePanel === 'Categories'" class="container">
            <p class="p3 p-[20px]  mb-[20px]" style="text-align: center">Lorem ipsum dolor sit amet consectetur,
                adipisicing elit. Odit
                asperiores ea neque quae eaque possimus vel amet quisquam fugiat sequi repudiandae ex, perferendis minus
                illum. Sit autem nesciunt totam deserunt!</p>
            <form class="card-shadowed mb-[50px] w-[100%] " action="" @submit.prevent="submit">
                <h6 class="p-[15px] mb-[20px]  text-center">Add Categories</h6>
                <div class="form-content">
                    <p class="p2  ">Select Categories</p>
                    <input style="width: 80%">
                    <button style="width: 40px;height: 40px" class="p-[10px] purple w-[100px] ">+</button>
                    <div class="mb-[40px] w-[100%]" style="background-color:var(--light-grey)">
                        <ul>
                            <li v-for="category in categories" class="p-[5px]">{{ category }}</li>
                        </ul>
                    </div>
                    <ul class="w-[100%] flax flex-wrap gap-1  ">
                        <li class="inline-flex gap-1">
                            <p class="category-pill"> Travelling <span class="flex items-center justify-center p-[3px]">X</span>
                            </p>
                        </li>
                        <li class="inline-flex gap-1">
                            <p class="category-pill"> Travelling <span class="flex items-center justify-center p-[3px]">X</span>
                            </p>
                        </li>
                        <li class="inline-flex gap-1">
                            <p class="category-pill"> Travelling <span class="flex items-center justify-center p-[3px]">X</span>
                            </p>
                        </li>
                        <li class="inline-flex gap-1">
                            <p class="category-pill"> Travelling <span class="flex items-center justify-center p-[3px]">X</span>
                            </p>
                        </li>
                        <li class="inline-flex gap-1">
                            <p class="category-pill"> Travelling <span class="flex items-center justify-center p-[3px]">X</span>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="button-section flex justify-between         p-[20px]">
                    <button @click.prevent="moveTo('Bio')" class="purple" type="submit">Bio</button>
                    <button @click.prevent="submit()" class="purple" type="submit">Finish</button>
                </div>
            </form>
        </div>
        <div v-if="activePanel === 'Finish'" class="container">
            <form class="card-shadowed mb-[50px] w-[100%] " action="" @submit.prevent="submit">
                <h6 class="p-[15px] mb-[20px]  text-center">Welcome</h6>
                <div class="form-content">
                    <p class="p3 p-[20px]  mb-[20px]" style="text-align: center">Lorem ipsum dolor sit amet consectetur,
                        adipisicing elit. Odit
                        asperiores ea neque quae eaque possimus vel amet quisquam fugiat sequi repudiandae ex,
                        perferendis minus
                        illum. Sit autem nesciunt totam deserunt!</p>
                </div>
                <div class="button-section flex justify-between         p-[20px]">
                    <Link as="button" :href="'/login'" class="purple" type="submit">Log In</Link>
                </div>
            </form>
        </div>
    </div>
    <footer>

    </footer>
</template>

<style lang="scss" scoped>
@import "../sassLoader";

.form-content {
    div {
        ul {
            li {
                &:hover {
                    background-color: var(--t-pink);
                    color: white;
                }
            }
        }
    }
}

</style>
