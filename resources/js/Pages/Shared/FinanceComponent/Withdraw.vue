<script setup>
import Modal from "../../../Components/Modal.vue"
import {reactive} from "vue";

const props = defineProps(['Withdrawal'])

const withdraw = reactive({
    agent:null,
    amount:0,
    phone:null,
    password:null,
})

function selectAgent(payload){
    withdraw.agent = payload
    modal.openModal()
}

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

function makeWithdrawal(){
    axios.post(route('makeWithdrawal'),withdraw).then((resp) => {
        console.log(resp)
    }).catch((err) => {
        console.log(err)
    })
}

</script>
<template>
    <div>
        <teleport to=body>
            <Modal :visible="modal.properties.visible">
                <div class="bid-display">
                    <div class="bid-container">
                        <div class="header">
                            <h6>Make Deposit</h6>
                            <button class="text-white" @click="modal.closeModal()">X</button>
                        </div>
                        <div class="body">
                            <form @submit.prevent="">
                                <div class="input-group">
                                    <label class="p3">Agent Name</label>
                                    <input type="text" v-model="withdraw.agent" disabled>
                                </div>
                                <div class="input-group">
                                    <label class="p3">Amount</label>
                                    <input type="number" v-model="withdraw.amount">
                                </div>
                                <div class="input-group mb-[30px]">
                                    <label class="p3">M-Pesa Number</label>
                                    <input type="number" v-model="withdraw.phone">
                                </div>
                                <div class="input-group mb-[30px]">
                                    <label class="p3">Enter your password</label>
                                    <input type="password" v-model="withdraw.password">
                                </div>
                                <button class="purple" type="submit" @click.prevent="makeWithdrawal">Confirm</button>
                            </form>
                        </div>
                        <div class="footer"></div>
                    </div>
                </div>
            </Modal>
        </teleport>
        <h6 class="mb-[10px]">How to make a withdraw</h6>
        <ol class="pl-[20px] mb-[30px]" type="1" >
            <li>Select an agent from the list below.</li>
            <li>Enter the amount of credits you wish to withdraw</li>
            <li>Provide your password</li>
            <li>Click confirm to complete</li>
            <li>The agent will transfer your money to your account</li>
        </ol>

        <h6 class="mb-[15px]">Agents List</h6>
        <ul>
            <li v-for="agent in  props.Withdrawal.agents" @click.prevent="selectAgent(agent.name)" class="w-[95%] m-[auto] mb-[20px] card-shadowed">
                <div class="user-icon">
                    <p>{{ agent.name[0] }}</p>
                </div>
                <section>
                    <p style="">{{ agent.username }}</p>
                    <div class="flex-wrap">
                        <label class="p4 font-semibold w-[100%] mr-[10px] text-grey-100"  >Limit:</label>
                        <p class="ml-[20px] p3">Ksh {{ agent.limit.lower_limit }} - Ksh {{ agent.limit.upper_limit }}</p>
                    </div>
                    <div class="flex-wrap" >
                        <label class="p3 font-semibold mr-[10px] w-[100%]">Method:</label>
                        <ul class="pl-[20px]" >
                            <li v-for="method in agent.methods" ><label class="p3">{{ method.name }} -</label><p class="p3">{{ method.account }}</p></li>
                        </ul>
                    </div>
                    <div class="flex-wrap">
                        <label class=" p4 font-semibold w-[100%] mr-[10px]">Waiting time:</label>
                        <p class="p3 pl-[20px]">{{ agent.wait_time.value }} {{ agent.wait_time.unit }}</p>
                    </div>
                </section>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    name: 'BalanceComponent'
}
</script>
<style lang="scss" scoped>
@import "../../sassLoader";

h6{
    color: #5d5d5d;
}

ol{
    li{
        display: list-item;
        list-style-type:decimal;
        color: grey;
    }
}

ul{
    li{
        display: flex;
        padding: 10px;
        gap: 8px;
        .user-icon{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--pale-red-1);
            p{
                color: white;
            }
        }
        section{
            &>div{
                display: flex;
                margin-bottom: 10px;
                ul{
                    padding: 0px;
                    margin: 0px;
                    li{
                        padding: 0 0px 0 20px ;
                        margin: 0px;
                    }
                }
            }
        }
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
