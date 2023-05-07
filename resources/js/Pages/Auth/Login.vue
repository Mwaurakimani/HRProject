<script  setup>
import { useForm } from '@inertiajs/vue3'
import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';
import {useAttrs} from "vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    errors:Object
});

const form = useForm({
    email:null,
    password:null
})

</script>

<template>
    <nav>
        <MobileNavigationComponent :activeNavButton="'Projects'"></MobileNavigationComponent>
        <DesktopNavigationVue :activeNavButton="'Projects'"></DesktopNavigationVue>
    </nav>
    <header>
        <div class="modile-header">
            <div class="container">
                <section>
                    <h1 class="pt-[13px]" style="color: var(--t-purple)">Log In</h1>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area">
        <div class="container">
            <form class="card-shadowed pt-[30px] mb-[50px] w-[100%] "  @submit.prevent="form.post(route('login'))">
                <div class="form-content ">
                    <section>
                        <div class="input-group">
                            <label for="">Email</label>
                            <input type="email" v-model="form.email">
                        </div>

                        <div class="input-group">
                            <label for="">Password</label>
                            <input type="password" v-model="form.password">
                        </div>
                    </section>
                    <span v-if="props.errors" class="error span-3 py-[10px] text-red-500">{{ props.errors.email }}</span>
                </div>
                <div class="button-section p-[20px] flex items-center justify-center">
                    <button class="purple" style="padding: 10px 20px"  type="submit" :disabled="form.processing">Log In</button>
                </div>
            </form>
        </div>
    </div>
    <footer>

    </footer>
</template>

<style lang="scss" scoped>
@import "../sassLoader";

//.container {
//    display: flex;
//    flex-wrap: wrap;
//
//    button {
//        border: 1px solid orange;
//        margin: 20px auto;
//        padding: 10px 30px;
//        border-radius: 4px;
//        font-weight: 700;
//        color: orange;
//
//        &:active,
//        &:hover {
//            background-color: orange;
//            color: white;
//        }
//    }
//}
//
//.content-area {
//    max-width: 1200px;
//    margin: auto;
//}
//
//form {
//    border-radius: 4px;
//    background-color: white;
//    padding: 20px;
//    width: 100%;
//    box-shadow: 0 0 6px grey;
//    margin-bottom: 40px;
//
//    h1 {
//        font-size: 1.1em;
//        font-weight: 700;
//        margin-bottom: 10px;
//        text-decoration: underline;
//    }
//    .form-content{
//        section:nth-of-type(1){
//            padding-bottom: 20px;
//            margin-bottom: 20px;
//            border-bottom:1px solid rgb(209, 209, 209);
//        }
//        .input-group{
//            margin-bottom: 10px;
//        }
//        label{
//            margin-bottom: 5px;
//            width: 100%;
//        }
//        input,select{
//            border-radius: 3px !important;
//            width: 100%;
//            height: 35px;
//            padding: 5px;
//        }
//    }
//    button{
//        padding:10px 15px
//    }
//}

@media only screen and (min-width: 980px) {
}

@media only screen and (min-width: 849px) {}
</style>
