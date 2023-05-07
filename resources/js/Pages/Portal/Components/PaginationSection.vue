<template>
  <div class="flex justify-between items-center">
    <div class="pagination">
      <ul class="flex">
        <li>&lt</li>
        <li class="active">1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
        <li>5</li>
        <li>6</li>
        <li>7</li>
        <li>8</li>
        <li>9</li>
        <li>&gt</li>
      </ul>
    </div>
    <section class=" w-[500px] display-stats mb-[15px]">
      <ul class="flex justify-end">
        <li>50 Projects found</li>
        <li> |</li>
        <li>Page 1 of 100</li>
      </ul>
    </section>
  </div>
</template>
<script>
export default {
  name: 'PaginationSection'
}
</script>

<style lang="scss" scoped >
@import "./../theme";
</style>
