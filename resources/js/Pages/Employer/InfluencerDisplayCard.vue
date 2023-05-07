<script setup>

import {onMounted} from "vue";

import followersFormat from "../../Helpers/followersFormat";
import {useForm} from "@inertiajs/vue3";
const props = defineProps([
    'bid'
])


function hireInfluencer(){
    axios.post(route('hireInfluencer'),{
        influencer_id: props.bid.user.id,
        bid_id: props.bid.id
    }).then((resp) => {
        console.log(resp)
    }).catch((err) => {
        console.log(err)
    })
}


</script>

<template>
  <div class="influencer-details">
      <div class="influencer-display-holder">
          <div class="header">
              <h3>View Influencer</h3>
              <button class="text-white" @click="$emit('closeModal')">X</button>
          </div>
          <div class="body">
              <div class="top-holder">
                  <div class="user-view">
                      <div class="image-view">
                          <div class="image">

                          </div>
                      </div>
                      <div class="details">
                          <h3>{{props.bid != null && props.bid.user != null ? props.bid.user.first_name +' '+props.bid.user.last_name : null}}</h3>
                          <a href="">View Profile</a>
                      </div>
                  </div>
                  <div class="social">
                      <ul v-if="props.bid && props.bid.user">
                          <li v-if="props.bid.user.social_accounts"  v-for="account in props.bid.user.social_accounts">
                              <label for="">{{ account.platform.name }}</label>
                              {{   }}
                              <p class="class-display">{{ followersFormat(account.influencer_class.min_count) }} - {{ followersFormat(account.influencer_class.max_count) }}</p>
                              <p class="class-name">{{ account.influencer_class.name }}</p>
                          </li>
                      </ul>
                  </div>
              </div>
              <div class="stats-holder">
                  <div class="stats">
                      <ul>
                          <li>
                              <label>Average Engagement</label>
                              <p>10%</p>
                          </li>
                          <li>
                              <label>Total Tasks Completed</label>
                              <p>36</p>
                          </li>
                          <li>
                              <label>Rating</label>
                              <p>5</p>
                          </li>
                      </ul>
                      <button @click.prevent="hireInfluencer">Hire</button>
                  </div>
              </div>
          </div>
          <div class="footer"></div>
      </div>
  </div>
</template>
<script>
export default {
  name: 'InfluencerDisplayCard'
}
</script>
<style lang="scss" scoped>
.influencer-details{
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    .influencer-display-holder{
        border-radius: 6px;
        box-shadow: 0 0 6px #7a7a7a;
        width: 90%;
        background-color: white;

        .header {
            padding: 0 10px;
            width: 100%;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid lightgrey;

            h3 {
                font-weight: bolder;
            }

            & > button {
                background-color: red;
                color: white;
                width: 20px;
                border-radius: 50%;

            }
        }

        .body {
            width: 100%;
            padding: 5px;
            .top-holder{
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                .user-view{
                    width: 100%;
                    height: 140px;
                    display: flex;
                    margin-bottom: 10px;

                    .image-view{
                        width: 140px;
                        height: 100%;
                        padding: 20px;
                        .image{
                            border-radius: 50%;
                            width: 100%;
                            height: 100%;
                            background-color: greenyellow;

                        }
                    }

                    .details{
                        display: flex;
                        justify-content: center;
                        padding-bottom: 20px;
                        padding-left: 20px;
                        flex-direction: column;
                        h3{
                            font-weight: bolder;
                            margin-bottom: 5px;
                        }

                        a{
                            font-size: 0.9em;
                            color: lightskyblue;
                            text-decoration: underline;
                        }
                    }
                }

                .social{
                    width: 100%;
                    height: 140px;
                    margin-bottom: 20px;
                    ul{
                        padding: 10px;
                        width: 100%;
                        li{
                            width: 100%;
                            display: flex;
                            margin-bottom: 10px;
                            justify-content: space-between;
                            &>*{
                                display: block;
                            }

                            label{
                                width: 85px;
                            }
                            p:nth-of-type(1){
                                width: 100px;
                            }
                        }
                    }
                }
            }
            .stats{
                width: 100%;
                margin-bottom: 20px;
                ul{
                    margin-bottom: 20px;
                    li{
                        display: flex;
                        margin: 10px;
                        label{
                            width: 200px;
                        }
                    }
                }
                button {
                    width: 80%;
                    display: block;
                    margin: auto;
                    margin-bottom: 10px;
                    border: 1px solid orange;
                    padding: 5px 20px;
                    color: orange;
                    border-radius: 4px;
                    transition: all ease 100ms;

                    &:active {
                        background-color: orange;
                        color: white;
                    }
                }
            }
        }
    }
}

@media only screen and (min-width: 980px) {
    .influencer-display-holder{
        max-width: 1000px;
    }
    .top-holder{
        flex-wrap: nowrap !important;
        .user-view{
            margin-right: 50px;
            width: auto !important;
        }
        .social{
            max-width: 550px;
            p:nth-of-type(1){
                margin-right: 40px;
            }
        }
    }

    .stats{
        ul{
            display: flex;
            li{
                flex-direction: column;
                p{
                    padding: 20px;
                }
            }
        }
    }
    button{
        max-width: 200px;
    }
}
</style>
