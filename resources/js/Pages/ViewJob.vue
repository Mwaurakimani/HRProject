<script setup>
import {inject} from "vue";
import MainPageNav from "@Components/MainPageNav.vue";
import Modal from "@Components/Modal.vue";
import {reactive} from "vue";

const currentUser = inject('currentUser');

console.log(currentUser)

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
            <div class="card-shadowed w-[400px] h-[400px] bg-white mx-[auto]">
                <div class="flex justify-end p-[10px]">
                    <span @click.prevent="modal.closeModal()"
                        style="border-radius: 50%;cursor:pointer;padding-top:3px;display:flex;align-items:center;justify-content:center;width: 20px; height: 20px;line-height: 20px;background-color: red; color: white">X</span>
                </div>
                <form @submit.prevent="applyForJob">
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text">
                    </div>
                    <div class="input-group">
                        <label>Email</label>
                        <input type="text">
                    </div>
                    <div class="input-group">
                        <label>ID</label>
                        <input type="text">
                    </div>
                    <div class="input-group">
                        <label>Age</label>
                        <input type="text">
                    </div>
                    <div class="input-group">
                        <label>CV</label>
                        <input type="file">
                    </div>
                    <button style="padding:5px 20px;background-color: dodgerblue;color: white;display: block;margin: auto" >Submit</button>
                </form>
            </div>
        </Modal>
    </teleport>
    <MainPageNav/>
    <div class="container flex" style="justify-content: space-around;gap:15px;">
        <section class="w-[70%] p-[20px] ">
            <h4>Job Title</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque eaque enim laborum libero nemo nihil
                quasi sint temporibus. Accusamus aperiam consequatur dolores esse eveniet maxime modi nulla odio quos
                voluptates?</p>
            <h6>Qualification</h6>
            <ul style="list-style: square" class="pl-[30px]">
                <li class="p2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li class="p2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li class="p2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li class="p2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
            </ul>
            <h6>About Job</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequuntur eligendi fuga iste nam
                pariatur quaerat quibusdam velit voluptatum. Inventore iste iusto molestias quia similique. Harum
                inventore minus pariatur quo?</p>
            <h6>Responsibilities</h6>
            <ul style="list-style: square" class="pl-[30px]">
                <li class="p2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li class="p2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li class="p2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li class="p2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
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

<style lang="scss" scoped>
@import "sassLoader";


section {
    & > * {
        margin-bottom: 15px;
    }
}

form {
    padding: 15px;

    .input-group {
        margin-bottom: 10px;
        label{
            width: 100px;
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

