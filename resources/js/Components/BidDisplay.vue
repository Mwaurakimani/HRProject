<script setup >

import MobileBidModalComponent from "./MobilOnlyComponents/MobileBidModalComponent.vue";
const props = defineProps(['bids','influencer','marketerHandle'])

</script>
<template>
  <div v-if="props.bids != null" class="bid-display flex justify-center flex-wrap">
      <MobileBidModalComponent
          v-if="props.influencer != null"
          :influencer="props.influencer.influencer"
          :marketerHandle="props.marketerHandle"
          v-for="bid in props.bids"
          :bid="bid"
          class="comp w-[90%] mb-[20px]">
      </MobileBidModalComponent>
      <MobileBidModalComponent
          :marketerHandle="props.marketerHandle"
          :influencer="props.influencer.influencer"
          v-else v-for="bid in props.bids"
          :bid="bid"
          class="comp w-[90%] mb-[20px]">
      </MobileBidModalComponent>
  </div>
</template>
<script>
export default {
  name: 'bidDisplay'
}
</script>
<style lang="scss" scoped>
@import "../Pages/sassLoader";

.comp:last-of-type{
    margin-bottom: 90px;
}

@media only screen and (min-width: 980px) {

}

@media only screen and (min-width: 849px) {
}
</style>
