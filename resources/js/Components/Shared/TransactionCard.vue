<script setup>

</script>

<template>
    <div class="card" >
        <section class="form" >
            <div class="input-g">
                <label class="p2">Amount</label>
                <input>
            </div>
            <div class="input-g">
                <label class="p2">Phone Number</label>
                <input>
            </div>
        </section>
        <div class="flex justify-end mb-[20px]" >
            <button class="text-white mr-[20px] px-[10px] py-[5px] "  style=" border-radius: 5px; background-color: var(--light-green)">Deposit</button>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './../../Pages/sassLoader';

section{
    padding: 20px;

    .input-g{
        margin-bottom: 20px;
    }

    label{
        width: 150px;
    }
    input{
        width: 100%;
    }
}

@include s-screens {

}
</style>
