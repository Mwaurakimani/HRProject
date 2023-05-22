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
    <teleport to="body">
        <Modal :visible="modal.properties.visible" style="display: grid;place-items: center">
            <div class="card w-[500px] h-[440px] bg-white mx-[auto]">
                <div class="flex justify-end p-[10px]">
                    <span @click.prevent="modal.closeModal()"
                        style="border-radius: 50%;cursor:pointer;padding-top:3px;display:flex;align-items:center;justify-content:center;width: 20px; height: 20px;line-height: 20px;background-color: red; color: white">X</span>
                </div>
                <form @submit.prevent="submitApplication">
                    <div class="input-group">
                        <label>First Name</label>
                        <input type="text" v-model="userData.firstName" >
                    </div>
                    <div class="input-group">
                        <label>Last Name</label>
                        <input type="text" v-model="userData.lastName" >
                    </div>
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" v-model="userData.email" >
                    </div>
                    <div class="input-group">
                        <label>ID</label>
                        <input type="text" v-model="userData.ID" >
                    </div>
                    <div class="input-group">
                        <label>Age</label>
                        <input type="number" min="18" v-model="userData.Age" >
                    </div>
                    <div class="input-group">
                        <label>CV</label>
                        <input type="file">
                    </div>
                    <button style="padding:5px 20px;background-color: dodgerblue;color: white;display: block;margin: auto" type="submit" @click.prevent="submitApplication" >Submit</button>
                </form>
            </div>
        </Modal>
    </teleport>
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
        <article class="w-[30%] p-[20px]">
            <button @click="modal.openModal()"
                    style="display: block;margin: auto;background-color: dodgerblue;color: white;padding: 5px 50px;border-radius: 8px">
                Apply
            </button>
        </article>
    </div>
</template>

<script>
import {useForm} from "@inertiajs/vue3";

export default {
    props:['job'],
    methods:{
        submitApplication(){
            axios.post(route('apiPostApplication',[this.job.id]))
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

