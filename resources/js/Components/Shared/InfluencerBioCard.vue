<script setup>

const props = defineProps(['bio'])
</script>

<template>
    <div class="card-shadowed pb-[20px] bg-white">
        <h6 class="text-grey-400 p-[10px] mb-[5px]" >Bio</h6>
        <p class="px-[20px] p3" >{{ props.bio }}</p>
    </div>
</template>

<style lang="scss" scoped>
@import './../../Pages/sassLoader';

@include s-screens {

}
</style>
