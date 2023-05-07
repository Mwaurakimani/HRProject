<template>
    <header class="flex justify-between">
        <h4 class="text-grey-300">{{title}}</h4>
        <slot>

        </slot>
    </header>
</template>
<script>
export default {
    name: 'PageTitle',
    props: ['title'],
}
</script>

<style lang="scss" scoped >
@import "./../theme";
</style>
