<script setup>
import {inject} from "vue";
import MainPageNav from "@Components/MainPageNav.vue";
import Modal from "@Components/Modal.vue";
import {reactive} from "vue";

const currentUser = inject('currentUser');
const modal = {
    properties: reactive({
        visible: false
    }),
    openModal: () => {
        document.body.style.overflow = "hidden";
        modal.properties.visible = true
    },
    closeModal: () => {
        document.body.style.overflow = "auto";
        modal.properties.visible = false
    }
}

function applyForJob() {
    console.log("hi");
}
</script>

<template>
    <MainPageNav/>
    <div class="container flex" style="justify-content: space-around;gap:15px;">
        <section class="w-[70%] p-[20px] ">
            <h4>{{ job.Title }}</h4>
            <p>{{ job.Description }}</p>
            <h6>Qualification</h6>
            <ul style="list-style: square" class="pl-[30px]">
                <li v-for="item in JSON.parse(job.Qualification)" class="p2">{{ item }}</li>
            </ul>
            <h6>About Job</h6>
            <p>{{ job.About }}</p>
            <h6>Responsibilities</h6>
            <ul style="list-style: square" class="pl-[30px]">
                <li v-for="item in JSON.parse(job.Responsibilities)" class="p2">{{ item }}</li>
            </ul>
        </section>
        <article v-if="application == 'undefined' || application == null" class="w-[30%] p-[20px]">
            <div class=" w-[500px] h-[380px] bg-white mx-[auto]">
                <form @submit.prevent="submitApplication" enctype="multipart/form-data">
                    <div class="input-group">
                        <label>First Name</label>
                        <input type="text" v-model="userData.firstName">
                    </div>
                    <div class="input-group">
                        <label>Last Name</label>
                        <input type="text" v-model="userData.lastName">
                    </div>
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" v-model="userData.email">
                    </div>
                    <div class="input-group">
                        <label>ID</label>
                        <input type="text" v-model="userData.ID">
                    </div>
                    <div class="input-group">
                        <label>Age</label>
                        <input type="number" min="18" v-model="userData.Age">
                    </div>
                    <div class="input-group">
                        <label>Upload CV</label>
                        <input type="file" @input="userData.cvFile = $event.target.files[0]">
                    </div>
                </form>
            </div>
            <button @click.prevent="submitApplication" style="display: block;margin: auto;background-color: dodgerblue;color: white;padding: 5px 50px;border-radius: 8px">
                Apply For Job
            </button>
        </article>
        <article v-else class="w-[30%] p-[20px]">
            <p>Application Status : <span>{{ application.status }}</span></p>
        </article>
    </div>
</template>

<script>
import {router, useForm} from "@inertiajs/vue3";

export default {
    props:['job','application'],
    methods:{
        submitApplication(){
            axios.post(route('apiPostApplication', [this.job.id]), this.userData,  {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    if (response.data.status == 0){
                        alert(response.data.message)
                    } else if (response.data.status == 1){
                        alert("Some of the Required Skills were not found in your CV")
                    } else if (response.data.status == 2){
                        router.post(route('OceanTest',[this.job.id,response.data.application_id]))
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    },
    data(){
        return {
            userData:useForm({
                firstName:"Peter",
                lastName:"Mwaura",
                email:"kim@email.com",
                ID:12345678,
                Age:18,
                cvFile:null
            })
        }
    }
}
</script>

<style lang="scss" scoped>
@import "sassLoader";


section {
    & > * {
        margin-bottom: 15px;
    }
}

form {
    padding: 15px;
    box-shadow: none !important;

    .input-group {
        margin-bottom: 10px;
        label{
            color: grey;
            width: 140px;
        }
        input{
            border-radius: 5px !important;
        }

        input[type="file"]{
            max-width: 250px;
        }
    }
}


</style>

