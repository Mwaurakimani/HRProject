<script setup>
import MobileNavigationComponent from "./../Components/MobileNavigationComponent.vue";
import {inject} from "vue";

const currentUser = inject('currentUser');

console.log(currentUser)
</script>

<template>
    <nav>
        <MobileNavigationComponent :active-nav-button="'Home'"></MobileNavigationComponent>
    </nav>
    <div class="banner flex flex-col justify-center align-middle mb-[50px]"
         style="align-items: center; height: calc(100vh - 60px)">
        <h3 class="text-center text-white mb-[20px] ">Welcome to Vumisha where brands and influencers make magic happen
            . . .</h3>
        <img class="p-[10px] w-[90px] mb-[10px]  h-[90px] bg-white" style="border-radius: 50%"
             src="/storage/DESIGN/WORKSPACE/LOGO/SVG/logo-icon.svg">
        <div class="banner-image">
        </div>
    </div>
    <section class="mb-[50px]">
        <h4 class=" text-center text-grey-400 mb-[20px]">What we do ...</h4>
        <div class="">
            <div class=" mx-[auto] description card-shadowed mb-[10px]   w-[300px] h-[350px]" v-for="item in 3"
                 style="position: relative;border-radius: 8px">
                <div class="text-holder pb-[20px] flex" style="align-items: flex-end;justify-content: center">
                </div>
                <p class="p4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis laudantium
                    nisi odit quod reprehenderit. Assumenda deleniti dignissimos doloribus eligendi, et qui. At deserunt
                    illum libero nulla officia quaerat quibusdam quidem.</p>
                <h6>Influencer</h6>
            </div>
        </div>
    </section>
    <section>
        <ul class="tab">
            <li class="p3 active">Influencer</li>
            <li class="p3">Marketer</li>
        </ul>
        <div class="body" style="background-color: var(--light-grey)">
            <p class="px-[7%] py-[20px] p4 text-center ">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, consequatur cumque, deserunt dolorem
                dolorum, exercitationem iusto molestiae neque nisi quo quos reiciendis sequi. Earum id, itaque labore
                libero minus optio!</p>
            <div class="journey-map h-[500px] bg-white ">

            </div>
        </div>
    </section>
    <section class="h-[300px] flex flex-col justify-around items-center" >
        <h3>Join the community</h3>
        <p class="p4 p-[30px] text-center ">Get to choose which brand to workwit,
            get value for your content with Vumisha</p>
        <button class="pink"> Take me there</button>
    </section>
    <footer>
    </footer>
</template>

<style lang="scss" scoped>
@import 'sassLoader';

.description {
    overflow: hidden;

    h6 {
        position: absolute;
        bottom: 0px;
        width: 100%;
        padding: 20px;
        text-align: center;
    }

    p {
        z-index: 10;
        top: 0px;
        width: 100%;
        padding: 20px;
        position: absolute;
        color: white;
    }
}

.text-holder {
    border-radius: 50%;
    width: 900px;
    height: 900px;
    background-color: var(--t-purple);
    position: absolute;
    top: -630px;
    left: -95%;
    z-index: 5;
}

.banner {
    background-color: var(--pink);

    .banner-image {
        width: 80%;
        height: 200px;
    }
}

.tab {
    width: 100%;
    display: flex;

    li {
        text-align: center;
        width: 50%;
        padding: 10px;
    }

    .active {
        background-color: var(--light-grey);
        color: var(--t-purple);
    }
}

section > .body {
    background-color: var(--light-grey);
    padding-bottom: 20px;
}

@include s-screens {

}
</style>
