<script setup>
import MobileProjectBreakdownDisplayCard
    from "../../../Components/MobilOnlyComponents/MobileProjectBreakdownDisplayCard.vue";
import followersFormat from "./../../../Helpers/followersFormat.js";
import {inject} from "vue";


const props = defineProps(['project','assignmentDetails','marketerStatus'])
const project = props.project
const assignmentDetails = inject('assignmentDetails')

</script>

<template>
  <div class="ProjectDetails px-[10px]">
      <div class="flex justify-end mb-[10px]" v-if=" assignmentDetails && assignmentDetails.is_assigned && props.marketerStatus == 'complete'">
          <button @click.prevent="$emit('markAsComplete',assignmentDetails.assignment)" class="purple p4">Mark Project as Complete</button>
      </div>
      <div class="card-shadowed p-[20px] mb-[20px]">
          <h6 class="text-grey-200 " >{{ project.marketer.user.first_name }} {{ project.marketer.user.last_name }}</h6>
          <div class="rating-card h-[30px]"></div>
          <hr class="mb-[10px]" style="background-color: var(--light-grey)" >
          <ul>
              <li class="flex justify-between w-[90%] mb-[10px]">
                  <label class="p3">Projects Posted:</label>
                  <p class="p3" >20</p>
              </li>
              <li class="flex justify-between w-[90%] mb-[10px]">
                  <label class="p3">Influencers Hired:</label>
                  <p class="p3" >20</p>
              </li>
              <li class="flex justify-between w-[90%] mb-[10px]">
                  <label class="p3">Total Spent:</label>
                  <p class="p3" >20</p>
              </li>
              <li class="flex justify-between w-[90%] mb-[10px]">
                  <label class="p3">Last Active:</label>
                  <p class="p3" >20</p>
              </li>
          </ul>
      </div>
      <div class="card-shadowed p-[20px] mb-[20px]">
          <h6 class="text-grey-200 mb-[10px]" >{{ project.title }}</h6>
          <p class="p3" >{{ project.description }}</p>
      </div>
      <div class="card-shadowed p-[20px] mb-[20px]">
          <h6 class="text-grey-200 mb-[20px] " >Details</h6>
          <ul>
              <li class="flex justify-between w-[90%] mb-[10px]">
                  <label class="p3">Status:</label>
                  <p class="p3" style="color: var(--light-green)"  >{{ project.status }}</p>
              </li>
              <li class="flex justify-between w-[90%] mb-[10px]">
                  <label class="p3">Price:</label>
                  <p class="p3" >Ksh {{ project.budget }}</p>
              </li>
              <li class="flex justify-between w-[90%] mb-[10px]">
                  <label class="p3">Run Time</label>
                  <p class="p3" >{{ project.runtime }} {{ project.metrics }}</p>
              </li>
              <li class="flex justify-between w-[90%] mb-[10px]">
                  <label class="p3">Total Bids</label>
                  <p class="p3" >{{ project.bids.length }}</p>
              </li>
          </ul>
      </div>
      <div class="card-shadowed p-[20px] mb-[20px]">
          <h6 class="text-grey-200 mb-[10px]" >Social Account Requirements</h6>
          <div class="social-accounts-display pl-[10px] pb-[20px]">
              <div class="flex" v-for="platform in props.project.platforms">
                  <div class="social-media-icon-holder h-[30px] w-[30px]">
                      <img v-if="platform.name == 'facebook'" class="w-[27px] h-[27px]" style="border-radius: 50%;padding: 2px" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">
                      <img v-if="platform.name == 'twitter'" class="w-[27px] h-[27px]" style="border-radius: 50%;padding: 2px" src="/storage/DESIGN/WORKSPACE/icons/twitter-icon.png">
                      <img v-if="platform.name == 'instagram'" class="w-[27px] h-[27px]" style="border-radius: 50%;padding: 2px" src="/storage/DESIGN/WORKSPACE/icons/Instagram-icon.png">
                      <img v-if="platform.name == 'tiktok'" class="w-[27px] h-[27px]" style="border-radius: 50%;padding: 2px" src="/storage/DESIGN/WORKSPACE/icons/tiktok-icon.png">
                  </div>
                  <p class="p3 pt-[5px] text-grey-200 ml-[10px] ">{{
                          platform.pivot.influencer_data.name
                      }} ({{

                          followersFormat(platform.pivot.influencer_data.min_count)
                      }} - {{ followersFormat(platform.pivot.influencer_data.max_count) }})</p>
              </div>
          </div>
      </div>
      <MobileProjectBreakdownDisplayCard :ProjectType="project.type" :ProjectRequirements="project.project_requirements"  class="w-[9 9%] pt-[20px]" ></MobileProjectBreakdownDisplayCard>
      <div class="card-shadowed p-[20px] mb-[80px]">
          <h6 class="text-grey-200 mb-[10px]" >Notes</h6>
          <p class="p3" >{{ project.notes }}</p>
      </div>
  </div>
</template>
<script>
export default {
  name: 'ProjectDisplay'
}
</script>
<style lang="scss" scoped>
@import "../../sassLoader";

@media only screen and (min-width: 980px) {
}

@media only screen and (min-width: 849px) {
}
</style>
