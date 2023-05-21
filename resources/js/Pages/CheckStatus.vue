<script setup>
import {inject} from "vue";
import MainPageNav from "@Components/MainPageNav.vue";

const currentUser = inject('currentUser');

console.log(currentUser)
</script>

<template>
    <MainPageNav/>
    <div class="container flex flex-wrap" style="justify-content: space-around;gap:15px;">
        <div class="container p-[20px] mb-[20px]">
            <input type="text" placeholder="Email">
            <input type="text" placeholder="ID">
            <button class="px-[20px] py-[5px]" style="background-color: dodgerblue;color: white" >View Applied Jobs</button>
        </div>
        <div v-for="item in 20"  class="card-shadowed w-[300px]  h-[330px] p-[15px] bg-white">
            <h5 class="mb-[15px]">Job Title</h5>
            <p class="mb-[20px]">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium amet assumenda facilis ipsam iste
                laudantium, magnam maxime neque nesciunt nobis optio praesentium quos rerum sapiente ut veniam vero
                voluptatibus!</p>
            <Link as="button" :href="route('viewJob',[1])">View</Link>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "./sassLoader";

.card-shadowed{
    button{
        display: block;
        margin: auto;
        background-color: dodgerblue;
        color: white;
        padding: 5px 20px;
    }
}
</style>

