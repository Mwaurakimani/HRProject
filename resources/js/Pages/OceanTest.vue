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
            <li v-for="(question,index) in JSON.parse(job.Questions)" class="card-shadowed p-[20px] ">
                <p>{{ question.Question }}</p>
                <ul v-if="question.TestType == 1" class="p-[20px]">
                    <li>
                        <input type="radio" :name="'question'+index" value="9" v-model="questions[index].ans">True<br>
                        <input type="radio" :name="'question'+index" value="1" v-model="questions[index].ans">False<br>
                    </li>
                </ul>
                <ul v-else-if="question.TestType == 2" class="p-[20px]">
                    <li>
                        <input type="radio" :name="'question'+index" value="9" v-model="questions[index].ans">Agree<br>
                        <input type="radio" :name="'question'+index" value="5" v-model="questions[index].ans">Neutral<br>
                        <input type="radio" :name="'question'+index" value="1" v-model="questions[index].ans">Disagree<br>
                    </li>
                </ul>
                <ul v-else-if="question.TestType == 3" class="p-[20px]">
                    <li>
                        <input type="radio" :name="'question'+index" value="9" v-model="questions[index].ans">Strongly Agree<br>
                        <input type="radio" :name="'question'+index" value="7" v-model="questions[index].ans">Agree<br>
                        <input type="radio" :name="'question'+index" value="5" v-model="questions[index].ans">Neutral<br>
                        <input type="radio" :name="'question'+index" value="3" v-model="questions[index].ans">Disagree<br>
                        <input type="radio" :name="'question'+index" value="1" v-model="questions[index].ans">Strongly Disagree<br>
                    </li>
                </ul>
            </li>
        </ul>

        <button class="px-[20px] py-[5px]" style="background-color: dodgerblue;color: white" @click.prevent="submitAnswer" >Submit</button>
    </div>
</template>

<script>
import route from "ziggy-js/src/js";
import {router} from "@inertiajs/vue3";

export default {
    props:['job','application_id'],
    data(){
        return {
            questions: (function (q){
                q.forEach((value) => {
                    value['ans'] = null
                })

                return q
            }(JSON.parse(this.job.Questions)))
        }
    },
    methods:{
        submitAnswer(){
            axios.post(route('apiSubmitTest',[this.job.id,this.application_id]),this.questions)
                .then((resp) => {
                    alert("Character Trait :"+resp.data.trait)
                    alert("Application Status will be updated after your application is reviewed")
                    router.visit(route('checkStatus'))
                })
        }
    }
}
</script>

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

