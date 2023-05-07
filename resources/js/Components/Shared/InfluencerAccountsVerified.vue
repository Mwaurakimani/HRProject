<script setup>

const props = defineProps(['socialAccounts'])
</script>

<template>
    <div class="card-shadowed pb-[20px] bg-white">
        <h6 class="text-grey-400 p-[10px] mb-[5px]" >Social Accounts</h6>
        <ul class="px-[20px]">
            <li v-for="account in props.socialAccounts" class="flex mb-[10px] pb-[10px]" style="border-bottom: 1px solid lightgrey">
                <div v-if="account.platform.name == 'facebook'" class="icon-holder w-[30px] w-[30px] mr-[30px]">
                    <img class="w-[30px] h-[30px]" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">
                </div>
                <div v-if="account.platform.name == 'twitter'" class="icon-holder w-[30px] w-[30px] mr-[30px]">
                    <img class="w-[30px] h-[30px]" src="/storage/DESIGN/WORKSPACE/icons/twitter-icon.png">
                </div>
                <div v-if="account.platform.name == 'instagram'" class="icon-holder w-[30px] w-[30px] mr-[30px]">
                    <img class="w-[30px] h-[30px]" src="/storage/DESIGN/WORKSPACE/icons/instagram-icon.png">
                </div>
                <div v-if="account.platform.name == 'tiktok'" class="icon-holder w-[30px] w-[30px] mr-[30px]">
                    <img class="w-[30px] h-[30px]" src="/storage/DESIGN/WORKSPACE/icons/tiktok-icon.png">
                </div>

                <div class="details-holder mr-[40px]">
                    <p>@{{ account.username }}</p>
                    <p>{{ account.influencer_class.name }}</p>
                    <p v-if=" account.status == 'verified' " style="color: var(--light-green)">Verified</p>
                    <p v-if=" account.status == 'unverified' " style="color: var(--pale-red-1)">Unverified</p>
                </div>

            </li>
        </ul>
    </div>
</template>

<style lang="scss" scoped>
@import './../../Pages/sassLoader';

ul{
  li:last-of-type{
      border: none !important;
  }
}

.icon-holder{
    width: 30px;
    height: 30px;
    border-radius: 50%;
    overflow: hidden;
    img{
        object-fit: cover;
    }
}

@include s-screens {

}
</style>
