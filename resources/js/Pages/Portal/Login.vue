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
    <header>
        <div class="modile-header">
            <div class="container">
                <section>
                    <h1 class="pt-[13px]" style="color: var(--t-purple)">Vumisha Portal</h1>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area mx-[auto]" style="width: 450px">
        <div class="container" style="height: 90vh;display: flex;align-items: center">
            <form class="card-shadowed pt-[30px] mb-[50px] w-[100%] "  @submit.prevent="form.post(route('AdminLogin'))">
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
                    <span v-if="props.errors && props.errors.email " class="error span-3 py-[10px] text-red-500">{{ props.errors.email }}</span>
                    <span v-if="props.errors && props.errors.password " class="error span-3 py-[10px] text-red-500">{{ props.errors.password }}</span>
                </div>
                <div class="button-section p-[20px] flex items-center justify-center">
                    <button class="purple" style="padding: 10px 20px"  type="submit" :disabled="form.processing">Log In</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "../sassLoader";

@media only screen and (min-width: 980px) {
}

@media only screen and (min-width: 849px) {}
</style>
