<script setup>
import {Link, router} from "@inertiajs/vue3";
import {onBeforeMount, onMounted, ref, toRef, useAttrs} from "vue";
import {authStore} from "../Store/AuthStore";
import {storeToRefs} from "pinia";
import { inject } from 'vue';

const currentUser = inject('currentUser');

const props = defineProps([
    'activeNavButton',
])

const auth = authStore()
const {status, user} = storeToRefs(auth)

const authenticated = ref(false);
const logeIn = ref(false);

onBeforeMount(() => {
    const authUser = currentUser;
    const {status, user} = storeToRefs(auth)
    logeIn.value = status.value
})

function logOut() {
    const auth = authStore()
    auth.unAuthenticate()
    router.post(route('logout'))
    router.visit('/')

}

onMounted(() => {
    let element = $('#user-icon');

    element.on({
        mouseenter: function () {
            let dropdown = element.find('.dropdown')

            dropdown.css({
                display:'block',
                zIndex:500,
            })

        },
        mouseleave: function () {

            let dropdown = element.find('.dropdown')

            dropdown.css({
                display:'none',
                zIndex:-100,
            })
        }
    });
})


</script>

<template>
    <div class="desktop-nav" style="background-color: orange;">
        <div class="logo-display">
            <h1 class="w-[100%] h-[100%] text-center" style="font-size:1.3em;line-height:60px;color:white">Vumisha</h1>
        </div>
        <div class="dropdown-desktop-menu">
            <ul class="m-[15px]">
                <Link :class="[activeNavButton == 'Home' ? 'active_button' : '']" :href="route('home')" as="li">Home
                </Link>
                <Link :class="[activeNavButton == 'Projects' ? 'active_button' : '']" :href="route('AllProjects')"
                      as="li">
                    Projects
                </Link>
                <Link :class="[activeNavButton == 'Influencers' ? 'active_button' : '']" :href="route('Influencer')"
                      as="li">
                    Influencer
                </Link>
                <Link :class="[activeNavButton == 'AboutUs' ? 'active_button' : '']" :href="route('AboutUs')" as="li">
                    About us
                </Link>
                <Link :class="[activeNavButton == 'ContactUs' ? 'active_button' : '']" :href="route('ContactUs')"
                      as="li">
                    Contact us
                </Link>
            </ul>
            <ul v-if="logeIn" class="ml-[80px]" style="display: flex; justify-content: space-between;">
                <li id="user-icon" :class="[activeNavButton == 'SignUpAs' ? 'active_button' : '','account_button']">
                    <div class="user-icon"  ref="user-icon">
                        <img src="/storage/user-icon.png">
                    </div>
                    <div class="dropdown">
                        <ul>
                            <Link as="li" :href="route('Account')">Account</Link>
                            <Link as="li" :href="route('MyProjects')">My Projects</Link>
                            <li>Notifications</li>
                        </ul>
                    </div>
                </li>
                <li @click.prevent="logOut"> Log Out</li>
            </ul>
            <ul v-else class="m-[15px] ml-[80px]" style="display: flex; justify-content: space-between;">
                <Link :class="[activeNavButton == 'SignUpAs' ? 'active_button' : '']" :href="route('login')" as="li">Log
                    In
                </Link>
                <Link :class="[activeNavButton == 'SignUpAs' ? 'active_button' : '']" :href="route('SignUpAs')" as="li">
                    Join
                </Link>
            </ul>
        </div>
    </div>
</template>

<style lang="scss">
.desktop-nav {
    width: 100%;
    height: fit-content;
    display: flex;
    justify-content: space-between;

    .logo-display {
        width: 180px;
        height: 60px;

    }

    .menu-burger {
        width: 50px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dropdown-desktop-menu {
        height: 60px;
        width: auto;
        display: flex;
        color: white;

        ul {
            display: flex;
            height: 100%;
            padding: 0px;
            margin: 0px;
            align-items: center;
            margin-left: 100px;

            li {
                height: 40px;
                line-height: 40px;
                cursor: pointer;
                transition: all ease 250ms;
                border-radius: 8px 8px 0px 0px;
                padding: 0px 10px;
                margin: 0px 10px;

                &:hover {
                    background-color: white;
                    color: orange;
                    border-radius: 8px 8px 8px 8px;
                }
            }

            .active_button {
                border-bottom: 2px solid white;
            }

            .account_button {
                border-radius: 0px;
                position: relative;
                display: block;
                &:hover {
                    background-color: orange;
                }

                #user-icon{
                    align-self: start;
                    justify-self: start;
                }

                .user-icon {
                    position: relative;
                    top: -10px;
                    width: 60px;
                    padding: 15px;
                    height: 60px;
                    &:hover{
                        background-color: orange;
                    }
                }

                & > .dropdown {
                    z-index: 500;
                    top: 50px;
                    left: -130px;
                    position: absolute;
                    width: 200px;
                    background-color: white;
                    box-shadow: 0px 3px 6px lightgrey;
                    padding: 0px;
                    display: none;



                    & > ul {
                        margin: 0px;
                        display: block;
                        width: 100%;
                        padding: 0px;
                        color: orange;

                        & > li {
                            margin: 0px;
                            border-radius: 0px;
                        }

                        & > li:hover {
                            background-color: orange;
                            color: white;
                        }
                    }
                }
            }
        }
    }
}

@media only screen and (max-width: 980px) {
    .desktop-nav {
        display: none;
    }

}</style>
