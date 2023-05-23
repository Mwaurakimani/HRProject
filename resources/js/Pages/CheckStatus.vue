<script setup>
import {inject} from "vue";
import MainPageNav from "@Components/MainPageNav.vue";

const currentUser = inject('currentUser');

function trimWithEllipsis(text) {
    const maxLength = 210;

    if (text.length > maxLength) {
        return text.slice(0, maxLength - 3) + "...";
    }

    return text;
}
</script>

<template>
    <MainPageNav/>
    <div class="container flex flex-wrap" style="justify-content: space-around;gap:15px;">
        <div class="container p-[20px] mb-[20px]">
            <input type="email" placeholder="Email" v-model="fieldData.email">
            <input type="text" placeholder="National ID" v-model="fieldData.id">
            <button class="px-[20px] py-[5px]" style="background-color: dodgerblue;color: white"
                    @click.prevent="getJobs">View Applied Jobs
            </button>
        </div>
        <div v-if="dataset != 'undefined' && dataset.length > 0" v-for="job in dataset"
             class="card-shadowed w-[300px]  h-[330px] p-[15px] bg-white">
            <h5 class="mb-[15px]">{{ job.Title }}</h5>
            <p class="mb-[20px]">{{ trimWithEllipsis(job.Description) }}</p>
            <Link as="button" :href="route('viewJob',[1,{user:fieldData.id}])">View</Link>
        </div>
    </div>
</template>

<script>
import {useForm} from "@inertiajs/vue3";

export default {
    data() {
        return {
            dataset: [],
            fieldData: useForm({
                email: "kim@email.com",
                id: "12345678"
            })
        }
    },
    methods: {
        getJobs() {
            axios.post(route('getAppliedJobs'), this.fieldData)
                .then((resp) => {
                    if (resp.data.data.length > 0) {
                        this.dataset = resp.data.data
                    }else {
                        alert("No data found")
                    }
                })
        }
    }
}
</script>

<style lang="scss" scoped>
@import "./sassLoader";

.card-shadowed {
    button {
        display: block;
        margin: auto;
        background-color: dodgerblue;
        color: white;
        padding: 5px 20px;
    }
}
</style>

