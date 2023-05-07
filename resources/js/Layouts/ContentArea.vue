<template>
  <div class="content-area">
      <slot></slot>
  </div>
</template>
<script>
export default {
  name: 'ContentArea'
}
</script>

<style lang="scss" scoped>
.content-area{
    width: 100%;
    height: 100%;
    padding: 18px;
}
</style>
