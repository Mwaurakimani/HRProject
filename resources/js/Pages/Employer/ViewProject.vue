<script setup>
import {storeToRefs} from 'pinia';
import {inject, onMounted, provide, reactive, ref} from 'vue';
import {authStore} from "../../Store/AuthStore";
import {router, useForm, usePage} from "@inertiajs/vue3";
import MobileInfluencerDashboardLayout from "../../Layouts/MobileInfluencerDashboardLayout.vue";
import MobileDashboardHeader from '../../Components/MobilOnlyComponents/MobileDashboardHeader.vue';
import ProjectDisplay from "./Components/ProjectDisplay.vue";
import BidDisplay from "../../Components/BidDisplay.vue";
import MediaDispay from "./Components/mediaDispay.vue";
import route from "ziggy-js/src/js/index.js";
import ChatsDisplay from "./Components/chatsDisplay.vue";


const currentUser = inject('currentUser');
const auth = authStore()
if (currentUser != null) {
    auth.authenticate()
}
const {status, user} = storeToRefs(auth)
const activeTab = ref('Project')


const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    project: Object
});
const project = reactive(props.project)

const modal = {
    properties: reactive({
        visible: false,
        bid: null
    }),
    openModal: (payload) => {
        document.body.style.overflow = "hidden";
        modal.properties.visible = true
        modal.properties.bid = payload
    },
    closeModal: () => {
        document.body.style.overflow = "auto";
        modal.properties.visible = false
        modal.properties.bid = null
    }
}

const bidForm = useForm({
    amount: null,
    comment: null
})
const fileForm = useForm({
    fileUpload: null
})

const assignmentDetails = reactive({
    is_assigned: is_assigned(),
    assignment: assignment()
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

let errorBag = reactive([])

onMounted(() => {
    // console.log(usePage().props.errors)
    if (usePage().props.errors != null) {
        if (usePage().props.errors.WorkspaceError != null) {
            errorBag[0] = usePage().props.errors
        }
    }
})

function switchTabs(payload) {
    activeTab.value = payload
}

function is_assigned() {
    let response = false;
    if (props.project != null) {
        if (props.project.bids != null) {
            for (let bid of props.project.bids) {
                if (bid.assignment != null) {
                    response = true;
                    break;
                }
            }
        }
    }

    return response
}

function assignment() {
    let assignment = null;
    if (props.project != null) {
        if (props.project.bids != null) {
            for (let bid of props.project.bids) {
                if (bid.assignment != null) {
                    assignment = bid.assignment

                    break;
                }
            }
        }
    }

    return assignment
}

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

function sendMessage(message) {
    let payload = {
        project: project,
        message: message.message
    }

    axios.post(route('sendMessage'),
        payload)
        .then((resp) => {
            let element = $('#chatWindow');

            if (props.project.chats) {
                props.project.chats.push(resp.data.chat)
            }else {
                props.project.chats = []
                props.project.chats.push(resp.data.chat)
            }


            element.animate({
                scrollTop: element.get(0).scrollHeight
            }, 1000)
        }).catch((err) => {
        console.log(err)
    })
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

function markAsComplete(payload) {
    if (true || confirm('Please confirm project completion.')) {
        axios.post(route('MarketerMarkAsComplete', payload))
            .then((response) => {
                if (response.data.status) {
                    // alert("Project was marked as complete.");
                    // alert("Credits have been transferred to the influencer");
                    window.location.reload();
                } else {
                    // alert("Error marking project as complete.");
                }
            })
            .catch((error) => {
                // alert("Error marking project as complete.");
            });
    }
}

provide('assignmentDetails', assignmentDetails)
</script>

<template>
    <teleport to=body>
        <MobileInfluencerDashboardLayout :activePage="'Projects'">
        </MobileInfluencerDashboardLayout>
    </teleport>
    <MobileDashboardHeader :backButton="true" :title="'Projects'"/>
    <nav>
        <ul class="w-[100%] h-[50px] items-center flex justify-around">
            <li @click.prevent="switchTabs('Project')"
                :class="['w-[33.3%]','text-center',activeTab === 'Project' ? 'active-tab':'' ]">Project
            </li>
            <li @click.prevent="switchTabs('Bids')"
                :class="['w-[33.3%]','text-center',activeTab === 'Bids' ? 'active-tab':'' ]">Bids
            </li>
            <li @click.prevent="switchTabs('Media')" v-if="is_assigned()"
                :class="['w-[33.3%]','text-center',activeTab === 'Media' ? 'active-tab':'' ]">Media
            </li>
            <li @click.prevent="switchTabs('Chat')" v-if="is_assigned()"
                :class="['w-[33.3%]','text-center',activeTab === 'Chat' ? 'active-tab':'' ]">Chat
            </li>
        </ul>
    </nav>
    <div class="container">
        <ProjectDisplay v-if="activeTab == 'Project'"
                        v-on:markAsComplete="markAsComplete"
                        :assignmentDetails="assignmentDetails"
                        :project="project"/>
        <BidDisplay v-if="activeTab == 'Bids'" :bids="props.project.bids" :marketerHandle.camel="true"
                    :influencer="false"/>
        <media-dispay v-if="activeTab == 'Media'" v-on:uploadFile="uploadFile" v-on:DeleteMedia="remove"
                      :assignmentDetails="assignmentDetails"></media-dispay>
        <ChatsDisplay v-if="activeTab == 'Chat'" v-on:sendMessage="sendMessage"
                      :chats="props.project.chats"></ChatsDisplay>
    </div>
</template>
<style lang="scss" scoped>
@import "../sassLoader";

.active-tab {
    height: 100%;
    line-height: 50px;
    background-color: var(--light-grey);
}

nav {
    box-shadow: 0 3px 2px lightgrey;
    position: sticky;
    top: 60px;
    background-color: white;
    margin-bottom: 20px;
    z-index: 500;
}

@media only screen and (min-width: 980px) {
}

@media only screen and (min-width: 849px) {
}
</style>

