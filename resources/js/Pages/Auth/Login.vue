<script  setup>
import { useForm } from '@inertiajs/vue3';
import MainPageNav from "@Components/MainPageNav.vue";

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
    <MainPageNav/>
    <div class="content-area w-[400px] mx-[auto]">
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
                    <button class="px-[20px] py-[5px]" style="background-color: dodgerblue;color: white" type="submit" :disabled="form.processing">Log In</button>
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
