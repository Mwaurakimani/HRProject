<script setup>
import { counterStore } from '../Store/stores';
import { storeToRefs } from 'pinia';
import MobileNavigationComponent from '../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../Components/DesktopNavigation.vue';
import InfluencerCard from '../Components/InfluencerCard.vue';
import ProjectCard from '../Components/ProjectsCard.vue';
import {inject} from "vue";
import {authStore} from "../Store/AuthStore";
import PaginationComponent from "./../Components/Shared/PaginationComponent.vue";
import MobileProjectDisplayCard from "../Components/MobilOnlyComponents/MobileProjectDisplayCard.vue";

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
    projects:Object
});

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
                    <h1 class="pt-[13px]" style="color: var(--t-purple)"  >Projects</h1>
                    <div class="actions pt-[10px] ">
                        <button>Filters</button>
                        <button>Sort</button>
                    </div>
                </section>
                <section class="flex-wrap" >
                    <p class="block mb-[10px] " >100 Projects found</p>
                    <ul class="flex flex-wrap gap-1 w-[100%] ">
                        <li> <p class="p4 category-pill text-white ">Facebook</p> </li>
                    </ul>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area">
        <div class="mobile-content-area">
            <div class="container mb-[30px]" v-for="project in props.projects">
                <MobileProjectDisplayCard :project="project" :link="'ViewProject'"></MobileProjectDisplayCard>
            </div>
            <div class="container pl-[20px] mb-[50px]  flex justify-center">
                <PaginationComponent></PaginationComponent>
            </div>
        </div>
    </div>
    <footer>

    </footer>
</template>

<style lang="scss" scoped>
@import "sassLoader";



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
