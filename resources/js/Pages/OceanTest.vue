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
    <MainPageNav/>
    <div class="container" style="justify-content: space-around;gap:15px;">
        <h3>Aptitude Test</h3>
        <ul>
            <li class="card-shadowed p-[20px] ">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aliquam eum expedita hic libero
                    sed tempora.</p>
                <ul class="p-[20px]">
                    <li>
                        <input type="radio" name="gender" value="male">Strongly Agree<br>
                        <input type="radio" name="gender" value="male">Agree<br>
                        <input type="radio" name="gender" value="male">Neutral<br>
                        <input type="radio" name="gender" value="female"> Disagree<br>
                        <input type="radio" name="gender" value="other"> Stongly Disagree
                    </li>
                </ul>
            </li>
        </ul>

        <button class="px-[20px] py-[5px]" style="background-color: dodgerblue;color: white" >Submit</button>
    </div>
</template>

<style lang="scss" scoped>
@import "sassLoader";


.container {
    & > * {
        margin-bottom: 15px;
    }
    &>ul>li{
        margin-bottom: 20px;
    }
}

form {
    padding: 15px;

    .input-group {
        margin-bottom: 10px;

        label {
            width: 100px;
        }

        input {
            border-radius: 5px !important;
        }

        input[type="file"] {
            max-width: 250px;
        }
    }
}


</style>

