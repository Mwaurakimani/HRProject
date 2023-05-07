<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps(['user'])

</script>

<template>
    <div class="card-shadowed pb-[20px] px-[5px] pt-[25px]  bg-white">
        <img  src="/storage/uploads/user.jpg" class="image mb-[10px] block mx-[auto]  w-[100px] h-[100px]  ">
        <p class="p2 mb-[5px] " style="text-align: center" > {{ props.user.first_name }} {{ props.user.last_name }}</p>
        <div class="h-[25px] flex items-center justify-center" style="width: fit-content">
            <div   class="star-icon w-[100%] h-[100%] p-[3px]">
                <img style="max-width: 20px;max-height: 20px" src="/storage/icons8-star-100.png">
            </div>
            <p class="pt-[3px]" >4.5</p>
        </div>
<!--        TODO::add status-->
        <p class="p3 mb-[5px] " style="text-align: center;color: var(--light-green)" >{{ props.user.status }}</p>
        <span @click.prevent="changeViewMode" class="icon w-[30px] h-[30px] p-[5px] ">
            <img src="/storage/DESIGN/WORKSPACE/PLATFORM%20DESIGN/icons8-pencil-64.png">
        </span>
    </div>
</template>

<script>
export default {
    methods:{
        changeViewMode(){
            this.$emit('changeViewMode','EditMode')
        }
    }
}
</script>

<style lang="scss" scoped>
@import './../../Pages/sassLoader';

img{
    object-fit: cover;
    border-radius: 50px;
}

.card-shadowed{
    display: grid;
    grid-template-rows: repeat(3,40px);
    grid-template-columns: 120px 1fr 30px;
    grid-template-areas:
    "image name icon"
    "image rating icon"
    "image status icon";
    grid-column-gap: 10px;

    &>img{
        grid-area: image;
        display: flex;
        @include flex-center;
    }
    p:nth-of-type(1){
        grid-area: name;
        display: flex;
        align-items: start;
        justify-content: start;
    }
    div{
        grid-area: rating;
        display: flex;
        align-items: start;
        justify-content: start;
    }
    p:nth-of-type(2){
        grid-area: status;
        display: flex;
        align-items: start;
        justify-content: start;
    }
    span{
        img{
            border-radius: 0px;
        }
    }
}



@include s-screens {

}
</style>
