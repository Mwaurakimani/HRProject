<script setup>

</script>

<template>
    <div class="card-shadowed w-[300px] bg-white">
        <div class="body pt-[10px]">
            <section class="w-[90%] mx-auto" style="border-bottom: 1px solid var(--light-grey);margin-bottom: 20px;padding-bottom: 20px">
                <div class="user-display">
                    <div class="image-section">
                        <img src="/storage/DESIGN/Uploads/influencer.jpg">
                    </div>
                    <div class="name-section">
                        <p class="p2" style="font-weight: bolder">Username</p>
                    </div>
                    <div class="ratings-section">

                    </div>
                    <div class="availability-section">
                        <p class="p2" style="color: var(--light-green)">Available</p>
                    </div>
                </div>
                <div class="bid-details  text-gray-500 p3">
                    <div>
                        <label class="w-[100px] " >Bid Amount</label>
                        <p class="w-[130px]" style=" display: inline-block; text-align: right" > KSh 300,000</p>
                    </div>
                    <div>
                        <label class="w-[100px] " >Runtime</label>
                        <p class="w-[130px]" style=" display: inline-block; text-align: right" > 24Hrs</p>
                    </div>
                </div>
            </section>
            <section class="w-[90%] mx-auto" style="border-bottom: 1px solid var(--light-grey);margin-bottom: 20px;padding-bottom: 20px">
                <p class="p2 mb-[5px]" style="font-weight: bolder">Description</p>
                <p class="p4 text-grey-100 " > Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque beatae blanditiis, dolores doloribus fugit ipsum laboriosam molestiae molestias nisi, pariatur perspiciatis recusandae tempore? Delectus eaque molestiae nam optio qui quod?</p>
            </section>

            <section class="flex justify-between mb-[20px]" >
                <button class="px-[10px] py-[5px] text-white mx-[5px]"  style="background-color: var(--bright-blue);border-radius: 25px" >View</button>
                <button class="px-[10px] py-[5px] text-white mx-[5px]"  style="background-color: var(--pale-red-1);border-radius: 25px" >Delete</button>
            </section>

        </div>
    </div>
</template>

<style lang="scss" scoped>
@import './../../Pages/sassLoader';

.card-shadowed {
    overflow: hidden;

    .header {
        align-items: flex-end;
    }

    .body {
        section {

            .user-display {
                margin-bottom: 20px;
                width: 100%;
                display: grid;
                grid-template-columns: [image] 100px [details] calc(100% - 100px);
                grid-template-rows: [row1] 30px [row2] 30px [row3] 30px;
                grid-column-gap: 10px;
                grid-template-areas:
                "image details-1"
                "image details-2"
                "image details-3";

                .image-section {
                    grid-area: image;
                    @include flex-center;

                    img{
                        width: 70px;
                        height: 70px;
                        border-radius: 50%;
                        object-fit: cover;
                        object-position: 0px 0px;
                    }

                }

                .name-section{
                    grid-area: details-1;
                    display: flex;
                    align-items: flex-end;
                }

                .ratings-section{
                    grid-area: details-2;
                    @include flex-center;
                }

                .availability-section{
                    grid-area: details-3;

                }
            }
        }
    }
}

@include s-screens {

}
</style>
