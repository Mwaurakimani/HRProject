<script setup>
const props = defineProps(['user'])
</script>

<template>
    <div class="card-shadowed w-[290px] pb-[20px] px-[5px]  bg-white">
        <h6 class="text-grey-400 p-[10px] mb-[5px]">About</h6>
        <div class=" px-[30px] " >
            <div class="flex justify-between" >
                <div class="" >
                    <label class="p3" style="color: darkgrey" >First Name</label>
                    <p class="p4 text-grey-200 " style="font-weight: 600" >{{ props.user.first_name }}</p>
                </div>
                <div class="" >
                    <label class="p3" style="color: darkgrey" > Last Name</label>
                    <p class="p4 text-grey-200 " style="font-weight: 600" >{{ props.user.last_name }}</p>
                </div>
            </div>
            <div class="" >
                <div class="" >
                    <label class="p3" style="color: darkgrey" >Gender</label>
<!--                    TODO::Add gender-->
                    <p class="p4 text-grey-200 " style="font-weight: 600" >{{ props.user.gender }}</p>
                </div>
            </div>
            <div class="" >
                <div class="" >
                    <label class="p3" style="color: darkgrey" >Location</label>
                    <!--                    TODO::Add Location-->
                    <p class="p4 text-grey-200 " style="font-weight: 600" >{{ props.user.location }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import './../../Pages/sassLoader';


.card-shadowed{
    &>div{
        &>div{
            margin-bottom: 15px;
        }
    }
}



@include s-screens {

}
</style>
