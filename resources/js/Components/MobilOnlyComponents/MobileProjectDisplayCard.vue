<script setup>
import {Link} from '@inertiajs/vue3';
import followersFormat from "../../Helpers/followersFormat.js";


const props = defineProps(['project','link'])

</script>

<template>
    <Link as="div" :href="route(props.link,props.project.id)" class="card-shadowed p-[10px] bg-white">
        <h6 class="p2 text-grey-400 px-[10px] pt-[20px]" >{{ props.project.title }}</h6>
        <p class="p-[10px] p4 ">{{ props.project.description }}</p>
        <p class="p1 text-grey-400 p-[10px]" >Social Account Requirements</p>
        <div class="social-accounts-display pl-[40px] pb-[20px]">
            <div class="flex" v-for="platform in props.project.platforms">
                <div class="social-media-icon-holder h-[30px] w-[30px]">
                    <img v-if="platform.name == 'facebook'" class="w-[27px] h-[27px]" style="border-radius: 50%;padding: 2px" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">
                    <img v-if="platform.name == 'twitter'" class="w-[27px] h-[27px]" style="border-radius: 50%;padding: 2px" src="/storage/DESIGN/WORKSPACE/icons/twitter-icon.png">
                    <img v-if="platform.name == 'instagram'" class="w-[27px] h-[27px]" style="border-radius: 50%;padding: 2px" src="/storage/DESIGN/WORKSPACE/icons/Instagram-icon.png">
                    <img v-if="platform.name == 'tiktok'" class="w-[27px] h-[27px]" style="border-radius: 50%;padding: 2px" src="/storage/DESIGN/WORKSPACE/icons/tiktok-icon.png">
                </div>
                <p class="p3 pt-[5px] text-grey-200 ml-[10px] ">{{ platform.pivot.influencer_data.name }} ({{
                        followersFormat(platform.pivot.influencer_data.min_count)
                    }} - {{ followersFormat( platform.pivot.influencer_data.max_count) }})</p>
            </div>
        </div>
        <div class="w-[80%] m-[auto] pb-[30px] flex justify-end" >
            <h6 class="text-grey-500" >Ksh {{ props.project.budget }}</h6>
        </div>
    </Link>
</template>
<script>
export default {
    name: 'Mobile-brand-Project-breakdown-Entry-component'
}
</script>
<style lang="scss" scoped>
@import './../../Pages/sassLoader';

.social-accounts-display{
    &>div{
        margin-bottom: 10px;
        width: 90%;
        border-bottom: 1px solid #e3e1e1;
    }
}

@include s-screens {

}
</style>
