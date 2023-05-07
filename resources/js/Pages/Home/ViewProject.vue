<script setup>
import {storeToRefs} from 'pinia';
import {inject, reactive} from 'vue';
import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';
import InfluencerCardBidView from '../../Components/InfluencerCardBidView.vue';
import convertDate from "../../Helpers/convertDate";
import {authStore} from "../../Store/AuthStore";
import {router, useForm} from "@inertiajs/vue3";
import Modal from "../../Components/Modal.vue"

import MobileProjectBreakdownDisplayCard
    from "../../Components/MobilOnlyComponents/MobileProjectBreakdownDisplayCard.vue";
import CategoriesDisplay from '../../Components/Shared/CategoriesDisplay.vue';


const currentUser = inject('currentUser');
const auth = authStore()
if (currentUser != null) {
    auth.authenticate()
}
const {status, user} = storeToRefs(auth)


const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    project: Object,
    assigned: Boolean
});
const project = reactive(props.project)

const modal = {
    properties: reactive({
        visible: false
    }),
    openModal: () => {
        document.body.style.overflow = "hidden";
        modal.properties.visible = true
    },
    closeModal: () => {
        document.body.style.overflow = "auto";
        modal.properties.visible = false
    }
}

const bidForm = useForm({
    amount: null,
    comment: null
})

function submitBid() {
    axios.post(route('MakeBid', [project[0].id]), bidForm).then((resp) => {
        if (resp.data.status) {
            alert("Bid was done successfully");
            router.visit(route('ViewProject', [project[0].id]))
        } else {
            alert("Bid could not be made")
        }
    }).catch((err) => {
        alert(err.response.data.message)
    }).finally(() => {
        modal.closeModal()
    })
}

function openWorkspace(payload) {
    router.visit(route('EmployerWorkspace', payload))
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
                    <h1 class="pt-[13px]" style="color: var(--t-purple)">View Project</h1>
                </section>
                <section class="flex" style="justify-content: flex-end;gap: 15px">
                    <button class="p3 text-white pink px-[15px]">View Bids</button>
                    <button class="p3 text-white purple px-[15px]">Bid Project</button>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area p-[10px]">
        <div class="card-shadowed mb-[30px] p-[10px]">
            <p class="p2 font-bold">Safaricom</p>
            <div class="w-[100%] h-[30px] "></div>
            <hr class="mb-[10px]" style="background-color: grey">
            <ul>
                <li class="flex mb-[10px] justify-between pr-[30px]">
                    <label class="text-grey-200" for="">Project Posted:</label>
                    <p>30</p>
                </li>
                <li class="flex mb-[10px] justify-between pr-[30px]">
                    <label class="text-grey-200" for="">Influencer Hired:</label>
                    <p>30</p>
                </li>
                <li class="flex mb-[10px] justify-between pr-[30px]">
                    <label class="text-grey-200" for="">Project Total Spent:</label>
                    <p>30</p>
                </li>
                <li class="flex mb-[10px] justify-between pr-[30px]">
                    <label class="text-grey-200" for="">Last Active:</label>
                    <p>30</p>
                </li>
            </ul>
        </div>
        <div class="card-shadowed mb-[30px] p-[10px]">
            <p class="p2 font-bold ">Project Title</p>
            <p class="p-[10px] p4 text-grey-200 ">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A amet
                architecto aspernatur at blanditiis dolorem, doloremque exercitationem hic iure labore molestiae nemo
                officia quam quod repellat saepe soluta velit voluptatibus.</p>
        </div>
        <div class="card-shadowed mb-[30px] p-[10px]">
            <p class="p2 font-bold mb-[20px]">Social Accounts Requirements</p>
            <div class="social-accounts-display pl-[40px] pb-[20px]">
                <div class="flex">
                    <div
                        class="social-media-icon-holder h-[40px] w-[40px]"
                    >
                        <img class="w-[25px] h-[25px]" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">

                    </div>
                    <p class="p3 text-grey-200 ml-[10px] ">Nano-Influencer (1K - 5K</p>
                </div>
                <div class="flex">
                    <div
                        class="social-media-icon-holder h-[40px] w-[40px]"
                    >
                        <img class="w-[25px] h-[25px]" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">

                    </div>
                    <p class="p3 text-grey-200 ml-[10px] ">Nano-Influencer (1K - 5K</p>
                </div>
                <div class="flex">
                    <div
                        class="social-media-icon-holder h-[40px] w-[40px]"
                    >
                        <img class="w-[25px] h-[25px]" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">

                    </div>
                    <p class="p3 text-grey-200 ml-[10px] ">Nano-Influencer (1K - 5K</p>
                </div>
            </div>
        </div>
        <div class="card-shadowed mb-[30px] p-[10px]">
            <p class="p2 font-bold mb-[15px] ">Details</p>
            <ul class="px-[20px]">
                <li class="flex mb-[10px] justify-between pr-[30px]">
                    <label class="p3 text-grey-200" for="">Pr oject Posted:</label>
                    <p class="p3" style="color: var(--light-green)">Available</p>
                </li>
                <li class="flex mb-[10px] justify-between pr-[30px]">
                    <label class="p3 text-grey-200" for="">Influencer Hired:</label>
                    <p class="p3">Ksh 300,000</p>
                </li>
                <li class="flex mb-[10px] justify-between pr-[30px]">
                    <label class="p3 text-grey-200" for="">Project Total Spent:</label>
                    <p class="p3">1 Week</p>
                </li>
                <li class="flex mb-[10px] justify-between pr-[30px]">
                    <label class="p3 text-grey-200" for="">Last Active:</label>
                    <p class="p3">30 min ago</p>
                </li>
            </ul>
        </div>
        <MobileProjectBreakdownDisplayCard class="mb-[30px] p-[10px]" ></MobileProjectBreakdownDisplayCard>
        <div class="card-shadowed mb-[30px] p-[10px]">
            <p class="p2 font-bold ">Notes </p>
            <p class="p-[10px] p4 text-grey-200 ">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A amet
                architecto aspernatur at blanditiis dolorem, doloremque exercitationem hic iure labore molestiae nemo
                officia quam quod repellat saepe soluta velit voluptatibus.</p>
        </div>
        <CategoriesDisplay class=" mb-[30px] p-[10px]"></CategoriesDisplay>

    </div>
    <footer>

    </footer>
</template>

<style lang="scss" scoped>
@import "./../sassLoader";

.social-accounts-display {
    & > div {
        margin-bottom: 10px;
        width: 90%;
        border-bottom: 1px solid #e3e1e1;
    }
}
</style>
