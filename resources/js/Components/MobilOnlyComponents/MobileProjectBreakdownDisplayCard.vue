<script setup>

import {reactive, ref} from "vue";
import followersFormat from "../../Helpers/followersFormat.js";


const props = defineProps(['ProjectRequirements','ProjectType'])
const ProjectRequirements = reactive(props.ProjectRequirements)

function openTargets(targets) {
    return JSON.parse(targets)
}
</script>

<template>
    <div class="card-shadowed bg-white mx-[auto] mb-[20px] pb-[10px]">
        <p class="p2 pl-[10px] font-bold mb-[20px] ">Project Breakdown</p>
        <section class="pl-[20px] mb-[30px]" v-for="requirement in ProjectRequirements">
            <div class="flex align-middle">
                <div class="social-media-icon-holder h-[40px] w-[40px]">
                    <img v-if="requirement.platform.name == 'facebook'" class="w-[20px] h-[20px]"
                         style="border-radius: 50%" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">
                    <img v-if="requirement.platform.name == 'twitter'" class="w-[20px] h-[20px]"
                         style="border-radius: 50%" src="/storage/DESIGN/WORKSPACE/icons/twitter-icon.png">
                    <img v-if="requirement.platform.name == 'instagram'" class="w-[20px] h-[20px]"
                         style="border-radius: 50%" src="/storage/DESIGN/WORKSPACE/icons/Instagram-icon.png">
                    <img v-if="requirement.platform.name == 'tiktok'" class="w-[20px] h-[20px]"
                         style="border-radius: 50%" src="/storage/DESIGN/WORKSPACE/icons/tiktok-icon.png">
                </div>
                <p class="p3 ml-[50px] " style="font-weight: bolder">{{ requirement.influencerClass.name }} ({{
                        followersFormat(requirement.influencerClass.min_count)
                    }} - {{ followersFormat(requirement.influencerClass.max_count) }})</p>
            </div>
            <ul class="text-grey-200 ">
                <li class="flex mb-[20px]">
                    <label class="w-[100px] p4 " style="font-weight: bolder">Location</Label>
                    <div>
                        <ul>
                            <li><p class="p4 text-grey-100 ">{{ requirement.post_location }}</p></li>
                        </ul>
                    </div>
                </li>
                <li class="flex">
                    <label class="w-[100px] p4 " style="font-weight: bolder">Target</Label>
                    <div>
                        <ul>
                            <li v-if="props.ProjectType == 'airtime'" class="flex w-[210px] justify-between">
                                <p class="p4 text-grey-100 ">{{( openTargets(requirement.targets)).unit}}</p>
                                <span>{{( openTargets(requirement.targets)).value}}</span>
                            </li>
                            <li v-else class="flex w-[210px] justify-between" v-for="(target,index) in openTargets(requirement.targets)" >
                                <p class="p4 text-grey-100 ">{{ index }}</p>
                                <span>{{target.value}}</span>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </section>
    </div>
</template>
<script>
export default {
    name: 'Mobile-brand-Project-breakdown-Entry-component'
}
</script>
<style lang="scss" scoped>
@import './../../Pages/sassLoader';

@include s-screens {

}
</style>
