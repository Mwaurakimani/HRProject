<script setup>
import {reactive, ref, watch} from "vue";

const activeTab = ref('facebook');

const props = defineProps([
    'supportedPlatforms'
])

const supportedPlatforms = props.supportedPlatforms.social_account

watch(
    supportedPlatforms,
    (newValue, oldValue) => {
        for (let platform in supportedPlatforms) {
            let name = platform
            for (let platformData in supportedPlatforms[name].platformDetail) {
                supportedPlatforms[name].platformDetail[platformData].status = (() => {
                    return !(supportedPlatforms[name].platformDetail[platformData].value === 'undefined' ||
                        supportedPlatforms[name].platformDetail[platformData].value == null ||
                        supportedPlatforms[name].platformDetail[platformData].value === 0);
                })()
            }
        }
    }
)

for (let platform in supportedPlatforms) {
    let name = platform

    for (let platformData in supportedPlatforms[name].platformDetail) {
        supportedPlatforms[name].platformDetail[platformData].status = (() => {

            return !(supportedPlatforms[name].platformDetail[platformData].value === 'undefined' ||
                supportedPlatforms[name].platformDetail[platformData].value == null ||
                supportedPlatforms[name].platformDetail[platformData].value === 0);
        })()
    }
}


function changeTab(payload) {
    activeTab.value = payload
}

</script>

<template>
    <div class="card-shadowed bg-white">
        <div class="header h-[40px] flex">
            <div
                @click.prevent="changeTab('facebook')"
                class="social-media-icon-holder h-[40px] w-[40px]"
                :class="{'active' : activeTab == 'facebook'}"
            >
                <img class="w-[30px] h-[30px]" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">
            </div>
            <div
                @click.prevent="changeTab('twitter')"
                class="social-media-icon-holder h-[40px] w-[40px]"
                :class="{'active' : activeTab == 'twitter'}"
            >
                <img class="w-[30px] h-[30px]" src="/storage/DESIGN/WORKSPACE/icons/twitter-icon.png">
            </div>
            <div
                @click.prevent="changeTab('instagram')"
                class="social-media-icon-holder h-[40px] w-[40px]"
                :class="{'active' : activeTab == 'instagram'}"
            >
                <img class="w-[30px] h-[30px]" src="/storage/DESIGN/WORKSPACE/icons/instagram-icon.png">
            </div>
            <div
                @click.prevent="changeTab('tiktok')"
                class="social-media-icon-holder h-[40px] w-[40px]"
                :class="{'active' : activeTab == 'tiktok'}"
            >
                <img class="w-[30px] h-[30px]" src="/storage/DESIGN/WORKSPACE/icons/tiktok-icon.png">
            </div>
        </div>
        <section v-for="(platform,platformKey) in supportedPlatforms">
            <div  v-if="activeTab === platformKey"
                 class="body mb-[20px]" id="facebook">
                <div class="input-group flex p-[20px]" style="flex-direction: column">
                    <label class="mb-[10px]" for="">Username</label>
                    <input style="border-radius: 5px !important;" v-model="supportedPlatforms[platformKey].username">
                </div>
                <div class="input-group flex p-[20px]" style="flex-direction: column">
                    <label class="mb-[10px]" for="">Influencer Class</label>
                    <select style=" width: 100%;border-radius: 5px !important;"
                            v-model="supportedPlatforms[platformKey].influencerClass">
                        <option value="Nano-Influencer">Nano-Influencer (1K - 10K )</option>
                        <option value="Micro-Influencer">Micro-Influencer (10K - 100K )</option>
                        <option value="Macro-Influencer">Macro-Influencer (100K - 500K )</option>
                        <option value="Meta-Influencer">Meta-Influencer (500K - 1M )</option>
                        <option value="Mega-Influencer">Mega-Influencer (1M+)</option>
                    </select>
                </div>
                <hr class="mb-[20px] bg-grey">
<!--                <section class="input-select pl-1 pr-[10px]">-->

<!--                    <div v-for="(detail,key) in supportedPlatforms[activeTab].platformDetail"-->
<!--                         class="input-g py-[5px] flex align-middle">-->
<!--                        {{}}-->
<!--                        <input class=" m-[5px] mr-[10px]" type="checkbox" style="border-radius: 3px"-->
<!--                               v-model="supportedPlatforms[activeTab].platformDetail[key].status"-->
<!--                               true-value="true"-->
<!--                               false-value="false"-->
<!--                        >-->
<!--                        <label class=" p-[5px] p4 w-[100px]">{{ key }}</label>-->
<!--                        <article class="grid" style="flex-wrap: wrap; width: calc(100% - 100px)">-->
<!--                            <input style="width: 100%;text-align: right" type="number" min="0"-->
<!--                                   v-model="supportedPlatforms[activeTab].platformDetail[key].value">-->

<!--                            <select-->
<!--                                v-if="supportedPlatforms[activeTab].platformDetail[key].options && supportedPlatforms[activeTab].platformDetail[key].options.length > 0"-->
<!--                                style="width:100px;justify-self: flex-end" class="mt-[5px] mr-[0px]"-->
<!--                                v-model="supportedPlatforms[activeTab].platformDetail[key].unit">-->
<!--                                <option v-for="option in supportedPlatforms[activeTab].platformDetail[key].options"-->
<!--                                        :value="option">/{{ option }}-->
<!--                                </option>-->
<!--                            </select>-->
<!--                        </article>-->
<!--                    </div>-->
<!--                </section>-->
            </div>
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

.card-shadowed {
    overflow: hidden;

    .header {
        border-bottom: 1px solid var(--light-grey);
        align-items: center;

        .social-media-icon-holder {
            @include flex-center;

            img {
                border-radius: 50%;
            }
        }

        .active {
            background-color: var(--light-grey);
        }
    }

    .body {
        background-color: var(--light-grey);
    }
}


.card-shadowed {
    overflow: hidden;

}

.input-g {
    input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }

    label {
        max-width: 100px;
    }
}

@include s-screens {

}
</style>
