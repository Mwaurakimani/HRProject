<script setup>
import {ref} from "vue";

const activeTab = ref('facebook');

function changeTab(payload) {
    activeTab.value = payload
}

</script>

<template>
    <div class="card-shadowed w-[390px] bg-white">
        <section>
            <h4>Credit<br> Balance</h4>
            <p class="p2" >Ksh 500</p>
        </section>
        <section>
            <h4>Pending <br>Balance</h4>
            <p class="p2" >Ksh 500</p>
        </section>
        <section>
            <h4>Pending <br>Withdrawals</h4>
            <p class="p2" >Ksh 500</p>
        </section>
        <section>
            <h4>Total <br>Balance</h4>
            <p class="p2" >Ksh 500</p>
        </section>
    </div>
</template>
<script>
export default {
    name: 'Mobile-brand-Project-breakdown-Entry-component'
}
</script>
<style lang="scss" scoped>
@import './../../Pages/sassLoader';

.card-shadowed{
    display: flex;
    flex-wrap: wrap;
    section{
        width: 180px;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: dimgrey;
        text-align: center;
        h4{
            margin-bottom: 10px;
        }
    }
}

@include s-screens {

}
</style>
