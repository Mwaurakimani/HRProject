<template>
  <nav class="w-[100%] px-[20px] h-[60px] bg-blue-700 mb-[20px] flex justify-between">
    <div class="h-[60px] flex">
      <Link :href="route('jobBoard')">Job Board</Link>
      <Link :href="route('checkStatus')">Check Status</Link>
    </div>
    <div style="display: grid;place-items: center">
      <Link as="button" :href="route('login')">Log In</Link>
    </div>
  </nav>
</template>
<script>
export default {
  name: 'MainPageNav'
}
</script>
<style scoped lang="scss">
@import "../Pages/sassLoader";


nav {
    color: white;

    a {
        display: block;
        height: 60px;
        line-height: 60px;
        margin: 0px 20px;

        &:hover {
            background-color: white;
            color: blue;
        }
    }

    button {
        height: 40px;
        display: block;
        padding: 10px 20px;
        background-color: white;
        color: blue;
        border-radius: 5px;

        &:hover {
            background-color: cornflowerblue;
            color: white;
        }
    }
}
</style>
