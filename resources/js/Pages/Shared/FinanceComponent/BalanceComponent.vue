<template>
    <div class="balance flex flex-wrap card-shadowed mb-[20px] w-[95%] mx-[auto]">
        <div class="w-[40%] m-[5%]  flex flex-col justify-center items-center ">
            <h6 class="text-center mb-[5px] text-grey-200">
                Credit
                <br>
                Balance
            </h6>
            <p class="p2 text-center ">Ksh {{balance.creditBalance}}</p>
        </div>
        <div class="w-[40%] m-[5%]  flex flex-col justify-center items-center ">
            <h6 class="text-center mb-[5px] text-grey-200">
                Escrow
                <br>
                Value

            </h6>
            <p class="p2 text-center ">Ksh {{balance.escrowValue}}</p>
        </div>
        <div class="w-[40%] m-[5%]  flex flex-col justify-center items-center ">
            <h6 class="text-center mb-[5px] text-grey-200">
                Pending
                <br>
                Deposit
            </h6>
            <p class="p2 text-center ">Ksh {{balance.pendingDeposits}}</p>
        </div>
        <div class="w-[40%] m-[5%]  flex flex-col justify-center items-center ">
            <h6 class="text-center mb-[5px] text-grey-200">
                Pending
                <br>
                Withdrawal
            </h6>
            <p class="p2 text-center ">Ksh {{balance.pendingWithdrawals}}</p>
        </div>

    </div>
    <h5 class="w-[96%] mx-[auto] mb-[20px] text-grey-200">Transactions</h5>
    <ul class="p-[10px]">
        <li v-for="transaction in  balance.transactions" class="flex mb-[10px] justify-between p-[10px] card-shadowed" style="width: 100%;gap: 5px;">
            <div class="grow" style="width: calc(100% - 70px)" >
                <div v-if="transaction.type"  class="flex items-center w-[100%]">
                    <label class=" p3 p-[10px]" >Type:</label>
                    <p class="p3  ">{{transaction.type}}</p>
                </div>
                <div v-if="transaction.type"  class="flex items-center w-[100%]">
                    <label class=" p3 p-[10px]" >Agent:</label>
                    <p class="p3  ">{{transaction.Agent}}</p>
                </div>
                <div v-if="transaction.type"  class="flex items-center">
                    <label class="p3 p-[10px]" >Value:</label>
                    <p class="p3  ">Ksh {{transaction.value}}</p>
                </div>
                <div v-if="transaction.type"  class="flex items-center">
                    <label class="p3 p-[10px]" >Ref:</label>
                    <p class="p3  ">{{transaction.ref}}</p>
                </div>
                <div v-if="transaction.type"  class="flex items-center">
                    <label class="p3 p-[10px]" >Date:</label>
                    <p class="p3  ">{{transaction.date}}</p>
                </div>
            </div>
            <div style="width: 70px">
                <p v-if="transaction.status == 'Confirmed'" class="p3" style="color: var(--light-green)">{{transaction.status}}</p>
                <p v-else class="p3">{{transaction.status}}</p>
            </div>
        </li>
    </ul>
</template>
<script>
export default {
    name: 'BalanceComponent',
    props: ['balance']
}
</script>
<style lang="scss" scoped>
@import "../../sassLoader";


nav {
    box-shadow: 0 3px 2px lightgrey;
    position: sticky;
    top: 60px;
    background-color: white;
    margin-bottom: 20px;
    z-index: 500;
}
ul{
    li:last-of-type{
        margin-bottom: 80px;
    }
}

label{
    font-weight: bolder;
}

@media only screen and (min-width: 980px) {
}

@media only screen and (min-width: 849px) {
}
</style>
