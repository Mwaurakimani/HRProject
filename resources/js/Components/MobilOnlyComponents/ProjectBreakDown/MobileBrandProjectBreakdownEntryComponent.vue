<script setup>
import {reactive, ref, watch} from "vue";

const props = defineProps(['platformData'])

const emit = defineEmits(['updatePlatformData'])

const activeTab = ref('facebook');

function changeTab(payload) {
    activeTab.value = payload
}

const platformData = reactive(props.platformData == null ? [
    {
        name:'facebook',
        selected:null,
        target:{
            unit:"Hrs",
            value:0,
        }
    },
    {
        name:'twitter',
        selected:null,
        target:{
            unit:"Hrs",
            value:0,
        }
    },
    {
        name:'instagram',
        selected:null,
        target:{
            unit:"Hrs",
            value:0,
        }
    },
    {
        name:'tiktok',
        selected:null,
        target:{
            unit:"Hrs",
            value:0,
        }
    }
] : props.platformData);

watch(platformData,(newPlatform,oldPlatform) =>{
    emit('updatePlatformData',[
        'Airtime',
        newPlatform
    ]);
})

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
        <div v-if="activeTab == 'facebook'" class="body" id="facebook">
            <p class="p4 p-3" style="color: var(--text-grey)">This title and description will change based on the item
                you tick. It will give you a description of where the post will be palced.</p>
            <div class="flex mb-[20px]  mx-auto">
                <section class="input-select pl-6" style="width: calc(100% - 180px)">
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Cover Photo" v-model="platformData[0].selected">
                        <label class="p4">Cover Photo</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Post" v-model="platformData[0].selected">
                        <label class="p4">Post</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Timeline" v-model="platformData[0].selected">
                        <label class="p4">Timeline</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Stories" v-model="platformData[0].selected">
                        <label class="p4">Stories</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Reels" v-model="platformData[0].selected">
                        <label class="p4">Reels</label>
                    </div>
                </section>
                <section class="input-select pr-[10px]">
                    <div class="w-[200px] h-[300px] bg-white" style="border-radius: 8px;border: 1px solid lightgrey">
                    </div>
                </section>
            </div>
            <p class="p4 p-3" style="color: var(--text-grey)">This title and description will change based on the item
                you tick. It will give you a description of where the post will be palced.</p>
            <div class="flex pl-4">
                <div class="input-g">
                    <input type="number" min="0" placeholder="0" style="border-radius: 3px" v-model="platformData[0].target.value">
                </div>
                <div class="input-g">
                    <select  v-model="platformData[0].target.unit">
                        <option value="Hrs">Hrs</option>
                        <option value="Days">Days</option>
                        <option value="Weeks">Weeks</option>
                    </select>
                </div>
            </div>
        </div>
        <div v-if="activeTab == 'twitter'" class="body" id="twitter">
            <p class="p4 p-3" style="color: var(--text-grey)">This title and description will change based on the item
                you tick. It will give you a description of where the post will be palced.</p>
            <div class="flex mb-[20px]  mx-auto">
                <section class="input-select pl-6" style="width: calc(100% - 180px)">
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Cover Photo" v-model="platformData[1].selected">
                        <label class="p4">Cover Photo</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Post" v-model="platformData[1].selected">
                        <label class="p4">Post</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Timeline" v-model="platformData[1].selected">
                        <label class="p4">Timeline</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Stories" v-model="platformData[1].selected">
                        <label class="p4">Stories</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Reels" v-model="platformData[1].selected">
                        <label class="p4">Reels</label>
                    </div>
                </section>
                <section class="input-select pr-[10px]">
                    <div class="w-[200px] h-[300px] bg-white" style="border-radius: 8px;border: 1px solid lightgrey">
                    </div>
                </section>
            </div>
            <p class="p4 p-3" style="color: var(--text-grey)">This title and description will change based on the item
                you tick. It will give you a description of where the post will be palced.</p>
            <div class="flex pl-4">
                <div class="input-g">
                    <input type="number" min="0" placeholder="0" style="border-radius: 3px" v-model="platformData[1].target.value">
                </div>
                <div class="input-g">
                    <select  v-model="platformData[1].target.unit">
                        <option value="Hrs">Hrs</option>
                        <option value="Days">Days</option>
                        <option value="Weeks">Weeks</option>
                    </select>
                </div>
            </div>
        </div>
        <div v-if="activeTab == 'instagram'" class="body" id="instagram">
            <p class="p4 p-3" style="color: var(--text-grey)">This title and description will change based on the item
                you tick. It will give you a description of where the post will be palced.</p>
            <div class="flex mb-[20px]  mx-auto">
                <section class="input-select pl-6" style="width: calc(100% - 180px)">
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Cover Photo" v-model="platformData[2].selected">
                        <label class="p4">Cover Photo</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Post" v-model="platformData[2].selected">
                        <label class="p4">Post</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Timeline" v-model="platformData[2].selected">
                        <label class="p4">Timeline</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Stories" v-model="platformData[2].selected">
                        <label class="p4">Stories</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Reels" v-model="platformData[2].selected">
                        <label class="p4">Reels</label>
                    </div>
                </section>
                <section class="input-select pr-[10px]">
                    <div class="w-[200px] h-[300px] bg-white" style="border-radius: 8px;border: 1px solid lightgrey">
                    </div>
                </section>
            </div>
            <p class="p4 p-3" style="color: var(--text-grey)">This title and description will change based on the item
                you tick. It will give you a description of where the post will be palced.</p>
            <div class="flex pl-4">
                <div class="input-g">
                    <input type="number" min="0" placeholder="0" style="border-radius: 3px" v-model="platformData[2].target.value">
                </div>
                <div class="input-g">
                    <select  v-model="platformData[2].target.unit">
                        <option value="Hrs">Hrs</option>
                        <option value="Days">Days</option>
                        <option value="Weeks">Weeks</option>
                    </select>
                </div>
            </div>
        </div>
        <div v-if="activeTab == 'tiktok'" class="body" id="tiktok">
            <p class="p4 p-3" style="color: var(--text-grey)">This title and description will change based on the item
                you tick. It will give you a description of where the post will be palced.</p>
            <div class="flex mb-[20px]  mx-auto">
                <section class="input-select pl-6" style="width: calc(100% - 180px)">
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Cover Photo" v-model="platformData[3].selected">
                        <label class="p4">Cover Photo</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Post" v-model="platformData[3].selected">
                        <label class="p4">Post</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Timeline" v-model="platformData[3].selected">
                        <label class="p4">Timeline</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Stories" v-model="platformData[3].selected">
                        <label class="p4">Stories</label>
                    </div>
                    <div class="input-g">
                        <input type="radio" style="border-radius: 3px" value="Reels" v-model="platformData[3].selected">
                        <label class="p4">Reels</label>
                    </div>
                </section>
                <section class="input-select pr-[10px]">
                    <div class="w-[200px] h-[300px] bg-white" style="border-radius: 8px;border: 1px solid lightgrey">
                    </div>
                </section>
            </div>
            <p class="p4 p-3" style="color: var(--text-grey)">This title and description will change based on the item
                you tick. It will give you a description of where the post will be palced.</p>
            <div class="flex pl-4">
                <div class="input-g">
                    <input type="number" min="0" placeholder="0" style="border-radius: 3px" v-model="platformData[3].target.value">
                </div>
                <div class="input-g">
                    <select  v-model="platformData[3].target.unit">
                        <option value="Hrs">Hrs</option>
                        <option value="Days">Days</option>
                        <option value="Weeks">Weeks</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Mobile-brand-Project-breakdown-Entry-component'
}
</script>
<style lang="scss" scoped>
@import './../../../Pages/sassLoader';

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

        .input-g {
            margin-bottom: 15px;
        }
    }
}


.card-shadowed {
    overflow: hidden;

}


@include s-screens {

}
</style>
