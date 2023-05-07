<script setup>

</script>

<template>
    <section class="flex flex-col ">
        <div class="mw-[200px] mb-[15px] " style="position:relative;">
            <p>the quick brown fox jummped over the lazy dogs
                sdncjsdnkjcs cskdncskjdbckj
                cslkjdnckjsdkj
                cdsjknkcjkjsd
                cksdjncjbksdbkcbskdjbckjsdc
                cdsjkckjbsdkjc
                cndskljckjbsdkcbkbsdkcjbs
                cdsljckjbsdkcjbs
                cdsjkcbkjbsdkckdjs</p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 65.1 69.48">
                <defs></defs>
                <g id="Layer_2" data-name="Layer 2">
                    <g id="Layer_1-2" data-name="Layer 1">
                        <path class="cls-1"
                              d="M60.18,68.62l-58.09-31a3,3,0,0,1-.52-5L38.84,1.21a3,3,0,0,1,4.8,1.35L64.44,65A3,3,0,0,1,60.18,68.62Z"/>
                    </g>
                </g>
            </svg>
        </div>
        <p class="text-grey-200 p3" style="align-self: flex-end" >May 3, 2023</p>
    </section>
</template>
<style lang="scss" scoped>
@import './../../Pages/sassLoader';


div{
    background-color: var(--t-purple);
    padding: 10px;
    border-radius: 8px;
    min-height: 30px;

    P{
        color: white;
    }
    svg{
        bottom:-10px;
        right: -5px;
        position: absolute;
        width: 20px;
        position: absolute;
        .cls-1 {
            fill: var(--t-purple);
            stroke-miterlimit: 10;
        }
    }
}

@include s-screens {

}
</style>
