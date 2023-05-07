<script setup>
import { storeToRefs } from 'pinia';
import MobileNavigationComponent from '../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../Components/DesktopNavigation.vue';
import MobileInfluencerDisplayCard from "../Components/MobilOnlyComponents/MobileInfluencerDisplayCard.vue";

import {authStore} from "../Store/AuthStore";
import {inject} from "vue";
import PaginationComponent from "./../Components/Shared/PaginationComponent.vue";

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
    influencers:Object
});

</script>

<template>
    <nav>
        <MobileNavigationComponent :activeNavButton="'Projects'"></MobileNavigationComponent>
        <DesktopNavigationVue  :activeNavButton="'Home'" :authenticated="status"></DesktopNavigationVue>
    </nav>
    <header>
        <div class="modile-header">
            <div class="container">
                <section>
                    <h1 class="pt-[13px]" style="color: var(--t-purple)"  >Influencers</h1>
                    <div class="actions pt-[10px] ">
                        <button>Filters</button>
                        <button>Sort</button>
                    </div>
                </section>
                <section class="flex-wrap" >
                    <p class="block mb-[10px] " >100 Influencers found</p>
                    <ul class="flex flex-wrap gap-1 w-[100%] ">
                        <li> <p class=" p4 category-pill text-white ">Facebook</p> </li>
                    </ul>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area">
        <div class="mobile-content-area">
            <div class="container flex mb-[30px] flex-wrap justify-around" >
                <MobileInfluencerDisplayCard class="mb-[10px]"  v-for="influencer in 20" ></MobileInfluencerDisplayCard>
            </div>
            <div class="container pl-[20px] mb-[50px]  flex justify-center">
                <pagination-component></pagination-component>
            </div>
        </div>
    </div>
    <footer>

    </footer>
</template>

<style lang="scss" scoped>
header {
    width: 100%;
    margin-bottom: 20px;
    background-color: var(--light-grey);
    section{
        padding: 10px 10px;
        display: flex;
        justify-content: space-between;
        h1{
            font-weight: 800;
            font-size: 1.3em;
        }

        .actions{
            button{
                border-radius: 3px;
                font-size: 0.9em;
                padding:2px;
                border:1px solid rgb(201, 201, 201);
                background-color: rgb(226, 226, 226);
                margin: 0px 5px;
            }
        }
        p{
            color: grey;
        }
    }
}



@media only screen and (min-width: 980px) {
    header{
        section{
            padding: 20px 10px;
            h1{
                font-size: 2em;
            }
        }
    }

    .actions{
        button{
            border-radius: 3px;
            font-size: 0.9em;
            padding:5px 10px !important;
            border:1px solid orange !important;
            background-color: transparent !important;
            margin: 0px 5px;
            color: orange;

            &:hover{
                background-color: orange !important;
                color: white !important;
            }
        }
    }
}

@media only screen and (min-width: 849px) {}
</style>
