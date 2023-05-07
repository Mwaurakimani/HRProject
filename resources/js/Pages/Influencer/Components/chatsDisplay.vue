<script setup>
import {inject, onMounted, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import convertDate from "./../../../Helpers/convertDate";


const props = defineProps([
    'chats',
])

const currentUser = inject('currentUser');
const user = currentUser;

const chatWindow = ref(null)
const message = useForm({
    message: null
})
onMounted(() => {
    chatWindow.value.scrollTop = chatWindow.value.scrollHeight
})
</script>

<template>
    <div class="chats-display mb-[80px]">
        <div class="chat-holder">
            <div id="chatWindow" class="chat-timeline" ref="chatWindow">
                <ul>
                    <li v-for="chat in chats" :class="[chat.sender_id == user.id?'right-chat':'left-chat']">
                        <div class="message">
                            <div class="message-content">
                                <h6 v-if="chat.sender_id == user.id">You</h6>
                                <h6 v-else>Other</h6>
                                {{ chat.message }}
                            </div>
                            <div class="carret">

                            </div>
                        </div>
                        <div class="message-details">{{ convertDate(chat.created_at) }}</div>
                    </li>
                </ul>
            </div>
            <div class="send-pannel">
                <div class="input-group">
                    <textarea class="h-[40px]" v-model="message.message"></textarea>
                </div>
                <div class="button-holder">
                    <button class="purple" @click.prevent="$emit('sendMessage',message)">Send</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "chatsDisplay"
}
</script>

<style scoped lang="scss">
@import "../../sassLoader";

.chats-display {
    height: 100%;

    .chat-holder {
        height: 100%;

        .chat-timeline {
            width: 100%;
            height: 62vh;
            overflow-y: auto;

            ul {
                font-size: 0.9em;

                li {
                    display: flex;
                    flex-direction: column;
                    padding: 10px;
                    overflow: hidden;

                    h3 {
                        font-weight: bolder;
                        margin-bottom: 10px;
                    }
                }

                .left-chat {
                    margin-bottom: 10px;
                    padding: 10px;

                    .message {
                        position: relative;
                        width: 250px;
                        border-radius: 20px;
                        background-image: linear-gradient(200deg, #e0e0e0, #c4c4c4);

                        .message-content {
                            width: 100%;
                            height: 100%;
                            color: #494949;
                        }

                        .carret {
                            position: absolute;
                            transform: rotate(30deg);
                            width: 40px;
                            height: 40px;
                            border-radius: 5px;
                            background: conic-gradient(from 0deg at center, #c4c4c4 35deg, transparent 35deg);
                            top: calc(100% - 18px);
                            left: -30px;
                        }
                    }
                }

                .right-chat {
                    margin-bottom: 10px;
                    padding: 10px;
                    display: flex;
                    align-items: flex-end;

                    .message {
                        position: relative;
                        width: 250px;
                        border-radius: 20px;
                        background-image: linear-gradient(320deg, #fac05e, #f6ca8a);

                        .message-content {
                            width: 100%;
                            height: 100%;
                            color: #313131;
                        }

                        .carret {
                            position: absolute;
                            transform: rotate(-70deg);
                            width: 40px;
                            height: 40px;
                            border-radius: 5px;
                            background: conic-gradient(from 0deg at center, #fac05e 35deg, transparent 35deg);
                            top: calc(100% - 18px);
                            left: calc(100% - 10px);
                        }
                    }
                }

                .message-content {
                    padding: 18px;
                }

                .message {
                    margin-bottom: 10px;
                }

                .message-details {
                    color: grey;
                    font-weight: bolder;
                    margin: 5px;
                }
            }
        }

        .send-pannel {
            display: flex;

            .input-group {
                padding: 10px;

                textarea {
                    width: 100%;
                    border-radius: 3px;
                    border: 2px solid grey !important;
                    resize: none;
                }
            }

            .button-holder {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100px;
            }
        }
    }
}
</style>
