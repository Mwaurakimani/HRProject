<script setup>

import {inject, reactive} from "vue";
import {Link} from "@inertiajs/vue3";

let activeButton = inject('activeSideNavigationLink')

const links = reactive({
    section1:[
        {
            name: "dashboard",
            title: "Dashboard",
            link: "/dashboard"
        }
    ],
    section2:[
        {
            name: "Listings",
            title: "Listings",
            link: "/Admin/Listings"
        },
        {
            name: "Account",
            title: "Account",
            link: "/Admin/Account"
        },
    ],
})

</script>


<template>
  <div class="side-navigation">
      <div class="logo-section p-[10px]">
      </div>
      <ul>
          <ul>
              <Link
                  as="li"
                  v-for="item in links.section1"
                  :class="[item.name == activeButton ? 'activeLink':'']"
                  :href="item.link"
              >{{ item.title }}  </Link>
          </ul>
          <hr>
          <ul>
              <Link
                  as="li"
                  v-for="item in links.section2"
                  :class="[item.name == activeButton ? 'activeLink':'']"
                  :href="item.link"
              >{{ item.title }}  </Link>
          </ul>
          <hr>
          <ul>
              <Link
                  as="li"
                  v-for="item in links.section3"
                  :class="[item.name == activeButton ? 'activeLink':'']"
                  :href="item.link"
              >{{ item.title }}  </Link>
          </ul>

      </ul>
  </div>
</template>
<script>
export default {
  name: 'SideNavigation'
}
</script>

<style lang="scss" scoped>
.side-navigation{
    width: 100%;
    height: 100%;
    box-shadow: 0 0 6px lightgrey;
    background-color: dodgerblue;
    overflow-x: auto;
    overflow-y: hidden;

    .logo-section{
        width: 100%;
        height: 120px;
        display: grid;
        place-items: center;
    }

    ul{
        ul{
            li{
                width: 100%;
                color: white;
                padding: 10px 50px;
                cursor: pointer;
                &:hover{
                    background-color: #48B3E2;
                    color: white;
                }
            }
            .activeLink{
                background-color: white;
                color: dodgerblue;
            }
        }

        hr{
            margin: 10px;
            border: transparent;
            background-color: transparent;
        }

    }
}
</style>
