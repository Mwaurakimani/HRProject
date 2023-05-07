<script setup>
import {Link, router, useForm} from '@inertiajs/vue3';
import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';
import {inject, ref} from "vue";
import {authStore} from "../../Store/AuthStore";
import {storeToRefs} from "pinia";
import MobileInfluencerDashboardLayout from "../../Layouts/MobileInfluencerDashboardLayout.vue";
import MobileDashboardHeader from '../../Components/MobilOnlyComponents/MobileDashboardHeader.vue';
import PaginationComponent from "../../Components/Shared/PaginationComponent.vue";
import MobileProjectDisplayCard from '../../Components/MobilOnlyComponents/MobileProjectDisplayCard.vue';
import MobileBrandProjectBreakdownEntryComponent
    from "../../Components/MobilOnlyComponents/ProjectBreakDown/MobileBrandProjectBreakdownEntryComponent.vue";
import MobileBrandProjectBreakdownEntryComponentImpressions
    from "../../Components/MobilOnlyComponents/ProjectBreakDown/MobileBrandProjectBreakdownEntryComponentImpressions.vue";
import MobileBrandProjectBreakdownEntryComponentViews
    from "../../Components/MobilOnlyComponents/ProjectBreakDown/MobileBrandProjectBreakdownEntryComponentViews.vue";
import MobileBrandProjectBreakdownEntryComponentFollowers
    from "../../Components/MobilOnlyComponents/ProjectBreakDown/MobileBrandProjectBreakdownEntryComponentFollowers.vue";


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

const activeSection = ref('intro')
const platform = () => {
    switch (project.projectType) {
        case 'airtime':
            return 'Airtime'
        case 'impressions':
            return 'Impressions'
        case 'views':
            return 'Views'
        case 'followers':
            return 'Followers'
        default:
            return 'airtime'
    }
}

function submitProject() {
    axios.post(route('PostProject'), project).then((resp) => {
        if (resp) {
            router.visit(route("ViewOwnedProject", {
                id: resp.data.project.id
            }))
        }
    })
}

async function nextTab(payload, fun = null) {
    if (fun != null && !fun()) {
        return
    }

    if (payload === 'influencerClass' && activeSection.value === 'socialMedia') {
        if (boundActivePlatforms()) {
            activeSection.value = payload
        } else {
            return false;
        }
    }else if (payload === 'Details') {
        const isValidBudget = await budgetValidation();
        if (isValidBudget) {
            activeSection.value = payload
        } else {
            alert('You do not have enough credits in your account to fund this project. Please make a deposit and try again.')
            return false;
        }
    } else {
        activeSection.value = payload
    }
}

function verifyIntro() {
    if (project.title && project.projectType){
        return true;
    }else {
        alert("Please enter the title and select one of the project type")
        return false;
    }
}

const project = useForm({
    title: null,
    projectType: 'airtime',
    description: null,
    platform: {
        type: null,
        data: null,
    },
    influencerClass: [],
    budget: null,
    timeline: {
        period: 'Hrs',
        value: 0
    },
    notes: null,
    location: null,
})

function updatePlatformData(data) {
    project.platform.type = data[0]
    project.platform.data = data[1]
}

const boundActivePlatforms = () => {
    let bPlatforms = []
    project.influencerClass = []

    if (project.platform.data != null) {
        for (let [key, platform] of Object.entries(project.platform.data)) {
            if (platform.selected != null) {
                bPlatforms.push(platform.name)
            }
        }

        for (let platform of bPlatforms) {
            project.influencerClass.push(
                {
                    name: platform,
                    selectedClass: 'Nano-Influencer'
                }
            )
        }
        return true;
    } else {
        alert("Please select a platform and advert post location")
        return false
    }
}

async function budgetValidation(){
    try {
        const resp = await axios.post(route('validateBudget'), project);
        if (resp.data.status){
            console.log(true);
            return true;
        }
    } catch (err) {
        console.log("Error");
    }
    console.log(false);
    return false;
}

</script>

<template>
    <teleport to="body">
        <MobileInfluencerDashboardLayout :activePage="'Projects'">
        </MobileInfluencerDashboardLayout>
    </teleport>
    <MobileDashboardHeader :backButton="true" :title="'Create Projects'"/>

    <div v-if="activeSection == 'intro'" class="content-area">
        <div class="card-shadowed p-[20px] mx-[auto] mt-[30px] mb-[80px] w-[96%]">
            <h5 class="text-grey-200 pb-[20px] text-center">Project Intro</h5>
            <div class="mb-[20px]">
                <p class="p2 pb-[10px]">What would you like to name your project?</p>
                <input class="w-[100%]" type="text" placeholder="Project Title" v-model="project.title">
            </div>
            <div class="mb-[20px]">
                <p class="p2 pb-[10px]">How would you like Vumisha to assist you?</p>
                <ul class="pl-[20px]">
                    <li class="flex mb-[15px]">
                        <input class="mt-[5px]" type="radio" value="airtime" v-model="project.projectType">
                        <p>Get an influencer to post my advert for some time ( Great for promoting your brand )</p>
                    </li>
                    <li class="flex mb-[15px]">
                        <input class="mt-[5px]" type="radio" value="impressions" v-model="project.projectType">
                        <p>Get me Likes, Comments and shares for my advertisement ( Great for interacting and engaging
                            with Audience )</p>
                    </li>
                    <li class="flex mb-[15px]">
                        <input class="mt-[5px]" type="radio" value="views" v-model="project.projectType">
                        <p>Get me Views for my advert ( Great for creating product and brand awareness )</p>
                    </li>
                    <li class="flex mb-[15px]">
                        <input class="mt-[5px]" type="radio" value="followers" v-model="project.projectType">
                        <p>Get me Followers ( Great for increasing your brand audience on your platform )</p>
                    </li>
                </ul>
            </div>
            <div class="mb-[20px]">
                <p class="p2 pb-[10px]">Tell us more about your advert</p>
                <textarea class="w-[100%]" type="text" placeholder="Description"
                          v-model="project.description"></textarea>
            </div>
            <div class="flex justify-end">
                <button class="purple" @click.prevent="nextTab('socialMedia',verifyIntro)">Social Media</button>
            </div>
        </div>
    </div>
    <div v-if="activeSection == 'socialMedia'" class="content-area">
        <div class="card-shadowed px-[5px] py-[20px]  mx-[auto] mt-[30px] mb-[80px] w-[96%]">
            <h5 class="text-grey-200 pb-[20px] text-center">Social Media</h5>
            <MobileBrandProjectBreakdownEntryComponent
                v-on:updatePlatformData="updatePlatformData"
                v-if="platform() === 'Airtime'"
                :platformData="project.platform.type == 'Airtime' ? project.platform.data : null"
                class="mb-[20px]">
            </MobileBrandProjectBreakdownEntryComponent>

            <MobileBrandProjectBreakdownEntryComponentImpressions
                v-on:updatePlatformData="updatePlatformData"
                v-else-if="platform() === 'Impressions'"
                :platformData="project.platform.type == 'Impressions' ? project.platform.data : null"
                class="mb-[20px]">
            </MobileBrandProjectBreakdownEntryComponentImpressions>

            <MobileBrandProjectBreakdownEntryComponentViews
                v-on:updatePlatformData="updatePlatformData"
                v-else-if="platform() === 'Views'"
                :platformData="project.platform.type == 'Views' ? project.platform.data : null"
                class="mb-[20px]">
            </MobileBrandProjectBreakdownEntryComponentViews>

            <MobileBrandProjectBreakdownEntryComponentFollowers
                v-on:updatePlatformData="updatePlatformData"
                v-else-if="platform() === 'Followers'"
                :platformData="project.platform.type == 'Followers' ? project.platform.data : null"
                class="mb-[20px]">
            </MobileBrandProjectBreakdownEntryComponentFollowers>

            <div class="flex justify-between">
                <button class="purple" @click.prevent="nextTab('intro')">Introduction</button>
                <button class="purple" @click.prevent="nextTab('influencerClass')">Influencer Class</button>
            </div>
        </div>
    </div>
    <div v-if="activeSection == 'influencerClass'" class="content-area">
        <div class="card-shadowed p-[20px] mx-[auto] mt-[30px] mb-[80px] w-[96%]">
            <h5 class="text-grey-200 pb-[20px] text-center">Influencer Class</h5>
            <p class="text-center mb-[30px]">Based on your current project description, bellow a re the proposed
                influencer classes recommended for you project.</p>
            <div class="holder">
                <ul class="mb-[40px]">
                    <li v-for="(platform,key) in project.influencerClass" class="flex flex-wrap">
                        <div class="w-[20%] icon-section">
                            <img v-if="platform.name == 'facebook'" class="w-[30px] h-[30px]"
                                 style="border-radius: 50%;overflow: hidden;padding: 1px"
                                 src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">
                            <img v-if="platform.name == 'twitter'" class="w-[30px] h-[30px]"
                                 style="border-radius: 50%;overflow: hidden;padding: 1px"
                                 src="/storage/DESIGN/WORKSPACE/icons/twitter-icon.png">
                            <img v-if="platform.name == 'instagram'" class="w-[30px] h-[30px]"
                                 style="border-radius: 50%;overflow: hidden;padding: 1px"
                                 src="/storage/DESIGN/WORKSPACE/icons/instagram-icon.png">
                            <img v-if="platform.name == 'tiktok'" class="w-[30px] h-[30px]"
                                 style="border-radius: 50%;overflow: hidden;padding: 1px"
                                 src="/storage/DESIGN/WORKSPACE/icons/tiktok-icon.png">
                        </div>
                        <select class="w-[75%] mb-[10px]" v-model="project.influencerClass[key].selectedClass">
                            <option value="Nano-Influencer">Nano-Influencer (1K - 10K )</option>
                            <option value="Micro-Influencer">Micro-Influencer (10K - 100K )</option>
                            <option value="Macro-Influencer">Macro-Influencer (100K - 500K )</option>
                            <option value="Meta-Influencer">Meta-Influencer (500K - 1M )</option>
                            <option value="Mega-Influencer">Mega-Influencer (1M+)</option>
                        </select>
<!--                        <p class="w-[100%] pl-[20%]">Estimated Views : {{ 0 }}</p>-->
                    </li>
                </ul>
            </div>
            <div class="flex justify-between">
                <button class="purple" @click.prevent="nextTab('socialMedia')">Social Media</button>
                <button class="purple" @click.prevent="nextTab('budget')">Budget</button>
            </div>
        </div>
    </div>
    <div v-if="activeSection == 'budget'" class="content-area">
        <div class="card-shadowed p-[20px] mx-[auto] mt-[30px] mb-[80px] w-[96%]">
            <h5 class="text-grey-200 pb-[20px] text-center">Budget</h5>
            <div class="mb-[20px]">
                <p class="p2 pb-[10px]">What's the entire project budget?</p>
                <input class="w-[100%]" type="text" placeholder="In Ksh" v-model="project.budget">
            </div>
            <div class="mb-[100px]">
                <p class="p2 pb-[10px]">How long will the project last?</p>
                <div class="flex items-center">
                    <div class="flex items-center">
                        <p class="p2 pb-[10px] px-[10px]">Period</p>
                        <select style="width: 95px !important;" class="px-[5px]" v-model="project.timeline.period">
                            <option value="Hrs">Hrs</option>
                            <option value="Days">Days</option>
                            <option value="Weeks">Weeks</option>
                        </select>
                    </div>
                    <div>
                        <input class="w-[80%]" type="text" v-model="project.timeline.value">
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <button class="purple" @click.prevent="nextTab('influencerClass')">Influencer Class</button>
                <button class="purple" @click.prevent="nextTab('Details')">Details</button>
            </div>
        </div>
    </div>
    <div v-if="activeSection == 'Details'" class="content-area">
        <div class="card-shadowed p-[20px] mx-[auto] mt-[30px] mb-[80px] w-[96%]">
            <h5 class="text-grey-200 pb-[20px] text-center">Details</h5>
            <!--            <div class="mb-[20px]">-->
            <!--                <p class="p2 pb-[10px]">Categories</p>-->
            <!--                <input class="w-[100%]" type="text">-->
            <!--            </div>-->
            <div class="mb-[20px]">
                <p class="p2 pb-[10px]">Notes</p>
                <textarea class="w-[100%] h-[100px]" type="text" placeholder="Notes" v-model="project.notes"></textarea>
            </div>
            <div class="mb-[20px]">
                <p class="p2 pb-[10px]">Location</p>
                <input class="w-[100%]" type="text" placeholder="location" v-model="project.location">
            </div>
            <div class="flex justify-between">
                <button class="purple" @click.prevent="nextTab('budget')">Budget</button>
                <button class="purple" @click.prevent="submitProject">Finish</button>
            </div>
        </div>
    </div>

</template>


<style lang="scss" scoped>
@import "../sassLoader";
</style>
