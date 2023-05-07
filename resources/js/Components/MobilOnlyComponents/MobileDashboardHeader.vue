<script setup>

import {router} from "@inertiajs/vue3";

const props = defineProps({
    title:String,
    backButton:{
        type:Boolean,
        default:false
    }
})


function logOut() {
    axios.post('/logout')
    router.visit('/login')
}

function backLink(){
    window.history.back();
}


</script>
<template>
    <div class="dashboard_header h-[60px] bg-pink-400 text-white flex items-center ">
        <div @click.prevent="backLink" v-if="props.backButton" class="back_button w-[30px] h-[30px] p-[1px] ">
            <img src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-left-arrow-100.png" alt="">
        </div>
        <h4 class="ml-[15px]">{{ title }}</h4>
        <div class="menu-drop-down">
            <section class="h-[100%] flex justify-center items-center" >
                <img class="w-[30px]" src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-menu-vertical-96.png">
            </section>
            <section class="card-shadowed mobile-dropdown">
                <ul>
                    <button @click.prevent="logOut" >Log Out</button>
                </ul>
            </section>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "../../Pages/sassLoader";

.dashboard_header {
    position: sticky;
    top: 0px;
    z-index: 1000;

    .menu-drop-down {
        margin-left: auto;
        width: 40px;
        height: 100%;
        .mobile-dropdown{
            display: none;
            z-index: 0;
            width: 200px;
            position: relative;
            top: 2px;
            left: -160px;
            background-color: white;
            ul{
                padding: 10px;
                button{
                    width: 100% !important;
                    text-align: left;
                    color: grey;
                    padding: 3px 5px;
                    border-radius: 5px;
                    &:hover{
                        background-color: deeppink;
                        color: white;
                    }
                }
            }
        }

        &:hover{
            .mobile-dropdown{
                display: block;
                z-index: 1000;
            }
        }
    }


}
</style>
