<script setup>
import {storeToRefs} from 'pinia';
import {inject, provide, reactive, ref} from 'vue';
import MobileNavigationComponent from '../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../Components/DesktopNavigation.vue';
import {authStore} from "../Store/AuthStore";
import {router, useForm} from "@inertiajs/vue3";
import Modal from "../Components/Modal.vue"
import ProjectDisplay from "./Employer/Components/ProjectDisplay.vue";
import BidDisplay from "../Components/BidDisplay.vue";


const currentUser = inject('currentUser');
const auth = authStore()
if (currentUser != null) {
    auth.authenticate()
}
const {status, user} = storeToRefs(auth)


const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    project: Object
});
const project = reactive(props.project)
const activeTab = ref('project')

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

const bidForm = useForm({
    amount: null,
    comment: null
})

function submitBid() {
    axios.post(route('MakeBid', [project.id]), bidForm).then((resp) => {
        if (resp.data.status) {
            alert("Bid was made successfully");
            window.location.href = window.location.href
        }else {
            alert("Bid could not be made")
        }
    }).catch((err) => {
        if (err.response.data.message){
            alert(err.response.data.message)
        }else if (err.response.data){
            alert(err.response.data)
        }
    }).finally(() => {
        modal.closeModal()
    })
}

function openBids(){
    activeTab.value = 'bids'
}

function openProject(){
    activeTab.value = 'project'
}

provide('assignmentDetails',null)

</script>

<template>
    <teleport to=body>
        <Modal :visible="modal.properties.visible">
            <div class="bid-display">
                <div class="bid-container">
                    <div class="header">
                        <h6>Bid for Project</h6>
                        <button class="text-white" @click="modal.closeModal()">X</button>
                    </div>
                    <div class="body">
                        <form @submit.prevent="">
                            <div class="input-group">
                                <label class="p3" >Amount</label>
                                <input type="number" v-model="bidForm.amount">
                            </div>
                            <div class="input-group">
                                <label class="p3" >Comment</label>
                                <textarea v-model="bidForm.comment"></textarea>
                            </div>
                            <button class="purple" type="submit" @click.prevent="submitBid">Submit</button>
                        </form>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </Modal>
    </teleport>
    <nav>
        <MobileNavigationComponent :activeNavButton="'Projects'"></MobileNavigationComponent>
        <DesktopNavigationVue :activeNavButton="'Projects'"></DesktopNavigationVue>
    </nav>
    <header>
        <div class="modile-header">
            <div class="container">
                <section>
                    <h1 class="pt-[13px]" style="color: var(--t-purple)"  >Project</h1>
                    <div class="actions pt-[10px]">
                        <button v-if="activeTab =='project'" @click.prevent="openBids" class="pink mr-[10px]" style="padding-top: 8px">View Bids</button>
                        <button v-else @click.prevent="openProject" class="pink mr-[10px]" style="padding-top: 8px">View Project</button>
                        <button @click.prevent="modal.openModal()" class="purple" style="padding-top: 8px" >Bid Project</button>
                    </div>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area">
        <ProjectDisplay v-if="activeTab =='project'" :project="props.project"/>
        <bidDisplay
            v-if="activeTab =='bids'"
            :marketerHandle.camel="false"
            :influencer="true"
            :bids="props.project.bids"
            />
    </div>
    <footer>

    </footer>
</template>

<style lang="scss" scoped>


header {
    margin-bottom: 20px;

    section {
        padding: 10px 10px;
        display: flex;
        justify-content: space-between;

        h1 {
            font-weight: 800;
            font-size: 1.3em;
        }
        button {
            font-size: 0.8em;
        }

    }
}

.bidders-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;

    & > div {
        margin: 10px;
    }
}

.bid-display {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    .bid-container {
        border-radius: 6px;
        box-shadow: 0 0 6px #7a7a7a;
        width: 320px;
        background-color: white;

        .header {
            padding: 0 10px;
            width: 100%;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid lightgrey;

            h3 {
                font-weight: bolder;
            }

            & > button {
                background-color: red;
                color: white;
                height: 20px;
                padding: 0px;
                font-size: 0.9em;
                width: 20px;
                border-radius: 50%;

            }
        }

        .body {
            width: 100%;
            padding: 15px;

            form {
                .input-group {
                    margin-bottom: 10px;
                    width: 100%;
                    display: flex;
                    flex-wrap: wrap;

                    input, textarea {
                        width: 100%;
                        border-radius: 5px !important;
                        height: 30px;
                        padding: 0px 5px;
                        margin: 0px;
                        border: 1px solid lightgrey;
                    }

                    textarea {
                        height: 200px;
                        margin-bottom: 20px;
                    }

                    label {
                        width: 100%;
                        margin-bottom: 10px;
                    }

                }
            }
        }
    }
}


@media only screen and (min-width: 980px) {

}

@media only screen and (min-width: 849px) {
}
</style>
