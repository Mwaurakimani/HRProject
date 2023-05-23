<script setup>
import {Link} from '@inertiajs/vue3'


function logOut(){
    axios.post('/logout').then(() => {
        window.location.href = '/'
    })
}
</script>

<template>
  <div class="top-panel-holder">
      <div class="search-bar">
<!--          <div class="search-section flex items-center justify-center pl-[10px]">-->
<!--              <input class="w-[96%]" type="search" placeholder="Search...">-->
<!--          </div>-->
<!--          <div class="search-dropdown">-->

<!--          </div>-->
      </div>
      <div class="account-bar flex items-center">
          <div style="position:relative;" >
              <div class="flex items-center pt-[5px]">
                  <p class="mr-[10px]" >Username</p>
                  <img class="w-[40px]"  style="background-color: grey;border-radius: 50%;padding: 7px" src="/storage/user-icon.png" >
              </div>
              <div class=" account-dropdown " style="background-color: white;box-shadow: 0 0 6px lightgrey;position: absolute; top: 49px;left:-10px;padding: 5px"  >
                  <ul>
                      <li @click.prevent="logOut">Log Out</li>
                      <Link as="li" :href="'/'">Home</Link>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</template>
<script>
export default {
  name: 'TopNavigation'
}
</script>


<style lang="scss" scoped>
.top-panel-holder{
    width: 100%;
    height: 100%;
    box-shadow: 0 0 6px lightgrey;
    background-color: white;
    display: flex;
    justify-content: space-between;

    .search-bar{
        width: 450px;
        height: 100%;
        .search-section{
            width: 100%;
            height: 50px;
            input{
                border-radius: 8px;
                border: 1px solid lightgrey;
            }
        }
        .search-dropdown{
            display: none;
            width: 100%;
            height: 500px;
            background-color: green;
        }
    }

    .account-bar{
        height: 100%;
        margin-right: 20px;

        .notification-dropdown{
            display: none;
        }
        .account-dropdown{
            width: 150px;
            display: none;
            &>div:last-of-type:hover{
                display: block;
            }

            ul{
                li{
                    padding: 5px;
                    border-radius: 8px;
                    &:hover{
                        background-color: dodgerblue;
                        color: white;
                    }
                }
            }
        }

        &>div{
            height: 50px;
            .badge{
                font-size: 0.65em;
                background-color: orangered;
            }
            &:hover{

                &>div:last-of-type{
                    display: block;
                }
            }
        }

    }
}

</style>
