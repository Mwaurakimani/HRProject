<script setup>


defineProps(['visible'])

</script>

<template>
    <div :class="['modal-element',visible ? 'visible':'']" @click.prevent>
        <slot></slot>
    </div>
</template>

<style lang="scss" scoped>
//div {
//    padding: 5px;
//    display: flex;
//    align-items: center;
//    max-height: 40%;
//    overflow: auto;
//}

.modal-element {
    display: none;
    opacity: 0;
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100vw;
    height: 100vh;
    background-color: rgba(24, 24, 24, 0.62);
    z-index: -1000;
}

.visible {
    display: flex !important;
    opacity: 1 !important;
    z-index: 3000 !important;
}
</style>
