<script setup>
import {storeToRefs} from 'pinia';
import {inject, reactive, watch} from 'vue';
import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';
import InfluencerCardBidView from '../../Components/InfluencerCardBidView.vue';
import convertDate from "../../Helpers/convertDate";
import {authStore} from "../../Store/AuthStore";
import {router, useForm} from "@inertiajs/vue3";
import Modal from "../../Components/Modal.vue"
import InfluencerDisplayCard from "./InfluencerDisplayCard.vue";
import mediaDispay from "./Components/mediaDispay.vue";
import chatsDisplay from "./Components/chatsDisplay.vue";
import route from "ziggy-js/src/js";
import imageViewModal from "./Components/ImageViewModal.vue";
import pdfViewModal from "./Components/pdfViewModal.vue";


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
    project: Object,
    media: Object,
    chats:Object,
    assignment:Object,
    account_type:String
});
const project = reactive(props.project)

const media = reactive(props.media)

const modal = {
    properties: reactive({
        visible: false,
        media: null
    }),
    openModal: (payload) => {
        document.body.style.overflow = "hidden";
        modal.properties.visible = true
        modal.properties.media = payload
    },
    closeModal: () => {
        document.body.style.overflow = "auto";
        modal.properties.visible = false
        modal.properties.media = null
    }
}

const chats = props.chats

const bidForm = useForm({
    amount: null,
    comment: null
})

function submitBid() {
    axios.post(route('MakeBid', [project[0].id]), bidForm).then((resp) => {
        if (resp.data.status) {
            alert("Bid was done successfully");
            router.visit(route('ViewProject', [project[0].id]))
        }
    }).catch((err) => {
        alert("Error Bidding");
    }).finally(() => {
    })
}

function openWorkspace(payload) {
    router.visit(route('EmployerWorkspace', payload))
}

let mobileSectionDisplay = {
    properties: reactive({
        activeSection: "media"
    }),
    changeTabs: (payload) => {
        if (payload == 'chats') {
            mobileSectionDisplay.properties.activeSection = 'chats'
        } else {
            mobileSectionDisplay.properties.activeSection = 'media'
        }
    }
}

const mobileViewComponent = reactive({
    active: mobileSectionDisplay.properties.activeSection
})

watch(mobileSectionDisplay.properties, (newPayload) => {
    if (newPayload.activeSection == 'chats') {
        mobileViewComponent.active = newPayload.activeSection
        console.log(mobileViewComponent);
    } else {
        mobileViewComponent.active = newPayload.activeSection
        console.log(mobileViewComponent);
    }
})

const fileForm = useForm({
    fileUpload: null
})

function uploadFile(payload) {
    fileForm.fileUpload = payload

    axios.post(route('uploadFile'), {
        project: props.project,
        fileData: fileForm.fileUpload
    }, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((resp) => {
        if (resp.data.status) {
            alert("File Uploaded")
            window.location.reload();
        } else {
            alert(resp.data.error)
        }


    }).catch((err) => {
        alert("File is missing or is unsupported")
    })
}

function download(path) {
    const url = `/storage/${path}`;
    const a = document.createElement('a');
    a.href = url;
    a.download = path.split('/').pop();
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function remove(media) {
    if (confirm("Are you sure you want to delete this media?")) {
        axios.delete(route('DeleteMedia', {
            media: media
        }))
            .then((response) => {
                if (response.data.status) {
                    alert("Media deleted successfully.");
                    window.location.reload();
                } else {
                    alert("Error deleting media.");
                }
            })
            .catch((error) => {
                alert("Error deleting media.");
            });
    }
}

function sendMessage(message){
    let payload = {
        project: project[0],
        message:message.message
    }

    axios.post(route('sendMessage'),
        payload)
        .then((resp) => {
            let element = $('#chatWindow');

            props.chats.push(resp.data.chat)

            element.animate({
                scrollTop: element.get(0).scrollHeight
            }, 1000)
        }).catch((err) => {
        console.log(err)
    })
}

let project_status = reactive([])

function assignProjectStatus(){
    project_status[0] = props.assignment[0].assignments.marketer_status
}

assignProjectStatus()

</script>

<template>
    <teleport to=body>
        <Modal :visible="modal.properties.visible">
            <image-view-modal
                v-if="modal.properties.media != null && modal.properties.media.type == 'image'"
                :media="modal.properties.media"
                v-on:closeModel="modal.closeModal"
                v-on:download="download"
                v-on:DeleteMedia="remove"

            ></image-view-modal>
            <pdfViewModal
                v-if="modal.properties.media != null && modal.properties.media.type == 'pdf'"
                :media="modal.properties.media"
                v-on:closeModel="modal.closeModal"
                v-on:download="download"
                v-on:DeleteMedia="remove"

            ></pdfViewModal>
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
                    <h1>Projects</h1>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area">
        <div class="container">
            <div class="top-section">
                <div class="left-section">
                    <div class="cont-bid">
                        <label>Bid</label>
                        <p>{{ (project[0].bids).length }}</p>
                    </div>
                    <div class="cont-budget">
                        <label>Budget</label>
                        <p>Ksh 15,000</p>
                    </div>
                    <div class="cont-location">
                        <label>Location</label>
                        <p>{{ project[0].location }}</p>
                    </div>
                </div>
                <div class="right-section">
                    <p class="desktop-date">Date Posted : <span>{{ convertDate(project[0].created_at) }}</span></p>
                </div>
            </div>
            <div class="description-section">
                <h3>Description</h3>
                <p style="color:grey">{{ project[0].description }}</p>
            </div>
        </div>
        <div class="container actions-section">
            <select v-model="project_status[0]" >
                <option value="Assigned" >Assigned</option>
                <option value="Assigned" >Assigned</option>
                <option value="Progressing" >Progressing</option>
                <option value="Finished" >Finished</option>
            </select>
            <button v-if="props.account_type == 'Marketer'"  @click.prevent="update_status()">Update Status</button>
        </div>

        <div class="container working-area">
            <div class="mobile-working-area">
                <ul class="navigation-section">
                    <li>
                        <button @click.prevent="mobileSectionDisplay.changeTabs('media')"
                                :class="mobileSectionDisplay.properties.activeSection == 'media' ? 'active-section':''">
                            Media
                        </button>
                    </li>
                    <li>
                        <button @click.prevent="mobileSectionDisplay.changeTabs('chats')"
                                :class="mobileSectionDisplay.properties.activeSection == 'chats' ? 'active-section':''">
                            Chats
                        </button>
                    </li>
                </ul>
                <div v-if="mobileViewComponent.active == 'media'" class="media-area">
                    <media-dispay
                        v-on:openModal="modal.openModal"
                        :fileForm="fileForm"
                        :media="media"
                        v-on:uploadFile="uploadFile"
                        v-on:DeleteMedia="remove"
                    ></media-dispay>
                </div>
                <div v-if="mobileViewComponent.active == 'chats'" class="chat-area">
                    <chats-display :chats="chats" v-on:sendMessage="sendMessage"></chats-display>
                </div>
            </div>
            <div class="desktop-working-area">

            </div>
        </div>

        <div class="container bidders-container" style="box-shadow:none">

        </div>
    </div>
    <footer>

    </footer>
</template>
<style lang="scss" scoped>
* {
    font-size: 0.96em;
}

header {
    width: 100%;
    box-shadow: 0 0 6px rgb(182, 182, 182);
    margin-bottom: 20px;
    min-height: 80px;

    section {
        padding: 10px 10px;
        display: flex;
        justify-content: space-between;

        h1 {
            font-weight: 800;
            font-size: 1.3em;
        }

        .actions {
            button {
                border-radius: 3px;
                font-size: 0.9em;
                padding: 2px;
                border: 1px solid rgb(201, 201, 201);
                background-color: rgb(226, 226, 226);
                margin: 0px 5px;
            }
        }

        p {
            color: grey;
        }
    }
}

.content-area {
    padding: 10px;

    .container {
        border-radius: 3px;
        padding: 10px;
        box-shadow: 0 0 6px grey;
        margin-bottom: 20px;

        .top-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;

            .left-section {
                & > div {
                    display: flex;
                    margin-bottom: 5px;

                    label {
                        width: 70px;
                        font-weight: 600;
                    }
                }
            }

            .right-section {
                display: flex;
                flex-direction: column;
                align-items: flex-end;

                button {
                    margin-bottom: 10px;
                    border: 1px solid orange;
                    padding: 5px 20px;
                    color: orange;
                    border-radius: 4px;
                    transition: all ease 100ms;

                    &:active {
                        background-color: orange;
                        color: white;
                    }
                }

                .desktop-date {
                    font-size: 0.8em;
                    font-weight: 800;
                }
            }
        }

        & > div {
            margin-bottom: 10px;

            h3 {
                font-size: 1em;
                font-weight: 800;
                margin-bottom: 5px;
            }
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
                        border-radius: 5px;
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

                button {
                    border-radius: 5px;
                    width: 90%;
                    height: 40px;
                    color: orange;
                    display: block;
                    margin: auto;
                    text-align: center;
                    line-height: 30px;
                    border: 1px solid orange;

                    &:hover {
                        background-color: orange;
                        color: white;
                    }
                }
            }
        }
    }
}

.actions-section {
    display: flex;
    justify-content: space-between;

    select {
        border-radius: 8px;
        width: 200px;
    }

    button {
        border: 1px solid orange;
        padding: 3px 5px;
        border-radius: 8px;
        color: orange;

        &:active {
            background-color: orange;
            color: white;
        }
    }
}

.mobile-working-area {
    width: 100%;

    .navigation-section {
        width: 100%;
        height: 50px;
        display: flex;

        li {
            width: 100%;
            height: 100%;

            button {
                width: 100%;
                height: 100%;
                text-align: center;
                line-height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .active-section {
                background-color: #eaeaea;
                color: orange !important;
                font-weight: bolder;
            }
        }
    }

    .media-area {
        width: 100%;
    }

    .chat-area {
        width: 100%;
    }
}

@media only screen and (min-width: 980px) {
    header {
        section {
            padding: 20px 10px;

            h1 {
                font-size: 2em;
            }
        }
    }
}

@media only screen and (min-width: 849px) {
    .actions-section {
        justify-content: flex-end;

        select {
            margin-right: 10px;
        }
    }
}
</style>

