<script setup>
import {inject} from "vue";
import MainPageNav from "@Components/MainPageNav.vue";

const currentUser = inject('currentUser');

console.log(currentUser)
</script>

<template>
    <MainPageNav/>
    <div class="container flex flex-wrap" style="justify-content: space-around;gap:15px;">
        <div v-if="(jobs != undefined) && (jobs != null) && (jobs.length > 0)" v-for="job in jobs"  class="card-shadowed w-[300px]  h-[330px] p-[15px] bg-white">
            <h5 class="mb-[15px]">{{ job.Title }}</h5>
            <p class="mb-[20px]">{{ job.Description }}</p>
            <Link as="button" :href="route('viewJob',[job.id])">View</Link>
        </div>
        <div class="card-shadowed container  h-[330px] p-[15px] bg-white" style="display: grid;place-items: center">
            <h5 style="line-height: 40px;text-align: center">There are no job openings available <br> Please Check Later</h5>
        </div>

    </div>
</template>

<script>
export default {
    props:['jobs'],
}
</script>

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

