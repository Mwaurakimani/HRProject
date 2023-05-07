<script setup >
import {Link} from "@inertiajs/vue3";
import {inject} from "vue";
import {authStore} from "../Store/AuthStore.js";
import {storeToRefs} from "pinia";

const currentUser = inject('currentUser');
const auth = authStore()
if (currentUser != null) {
    auth.authenticate()
}

defineProps(['activeNavButton'])

function toggle_dropdown() {

    let height = $('.dropdown-mobile-menu').css('height')

    console.log();

    if (height === '0px') {
        $('.dropdown-mobile-menu').css({
            height: '320px'
        })
    } else {
        $('.dropdown-mobile-menu').css({
            height: '0px'
        })
    }


}
window.addEventListener('resize', function (event) {
    if (document.body.clientWidth > 980) {
        $('.dropdown-mobile-menu').css({
            height: '0px'
        })
    }
}, true);

function logout(){
    axios.post('/logout').then(()=>{
        window.location.href = '/login'
    })
}

</script>

<template>
    <div class="mobile-nav" style="background-color: var(--light-grey);">
        <div class="logo-display justify-around flex p-[14px]">
            <img   src="/storage/DESIGN/WORKSPACE/LOGO/SVG/logo-icon.svg" alt="logo">
            <img src="/storage/DESIGN/WORKSPACE/LOGO/SVG/logo-text.svg" alt="logo-name">
        </div>
        <div class="menu-burger w-[20px]" @click="toggle_dropdown">
            <img class="w-[40px]"  src="/storage/icons8-menu-rounded-24.png" alt="">
        </div>
        <div class="dropdown-mobile-menu">
            <ul class="m-[15px]">
                <Link :href="route('home')" as="li" :class="[activeNavButton === 'Home' ?'active_button':'']">Home</Link>
                <Link :href="route('AllProjects')" as="li" :class="[activeNavButton === 'Projects' ?'active_button':'']">Projects</Link>
                <Link :href="route('AboutUs')" as="li" :class="[activeNavButton === 'AboutUs' ?'active_button':'']">About us</Link>
                <Link :href="route('ContactUs')" as="li" :class="[activeNavButton === 'ContactUs' ?'active_button':'']">Contact us</Link>
            </ul>
            <hr style="width: 90%;margin:auto">
            <ul v-if="currentUser == null" style="display: flex; justify-content: space-between;" class="m-[15px]">
                <Link :href="'/login'" as="li" :class="[activeNavButton === 'LogIn' ? 'active_button' : '']">Log In</Link>
                <Link :href="route('SignUpAs')" as="li" :class="[activeNavButton === 'SignUpAs' ? 'active_button' : '']">Join</Link>
            </ul>
            <ul v-else style="display: flex; justify-content: space-between;" class="m-[15px]">
                <Link :href="'/Account'" as="li">Dashboard</Link>
                <li @click.prevent="logout" >Log Out</li>
            </ul>
        </div>
    </div>
</template>

<style lang="scss">
.mobile-nav {
    width: 100%;
    height: fit-content;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .logo-display {
        width: 250px;
        height: 60px;

    }

    .menu-burger {
        width: 50px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dropdown-mobile-menu {
        overflow: hidden;
        width: 100%;
        height: 0px;
        transition: all ease-in 250ms;
        background-color: white;
        box-shadow: 2px 0px 6px var(--light-grey);

        ul {
            li {
                padding: 10px;
            }
        }
        .active_button {
            color: var(--t-pink);
        }
    }
}



@media only screen and (min-width: 980px) {
    .mobile-nav {
        display: none;
    }
}
</style>
