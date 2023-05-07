<script setup>


</script>

<template>
    <div class="card w-[180px]" style="overflow: hidden" >
        <div class="holder" style="position:relative;" >
            <img src="/storage/uploads/user.jpg" style="height:150px;  object-fit: cover">
            <div class="overlay flex" style="position: absolute;top: 0px;align-items: flex-end;flex-wrap: wrap">
                <div class="wrapper w-[100%] pl-[5px]" >
                    <p class=" p3 text-white" >Username</p>
                    <div class=" flex flex-row gap-1 icon-holder">
                        <div>
                            <div
                                class="social-media-icon-holder h-[25px] w-[25px]"
                            >
                                <img class="w-[25px] h-[25px]" src="/storage/DESIGN/WORKSPACE/icons/facebook-icon.png">

                            </div>
                        </div>
                        <div>
                            <div
                                class="social-media-icon-holder h-[25px] w-[25px]"
                            >
                                <img class="w-[25px] h-[25px]" src="/storage/DESIGN/WORKSPACE/icons/twitter-icon.png">


                            </div>
                        </div>
                        <div>
                            <div
                                class="social-media-icon-holder h-[25px] w-[25px]"
                            >
                                <img class="w-[25px] h-[25px]" src="/storage/DESIGN/WORKSPACE/icons/instagram-icon.png">

                            </div>
                        </div>
                        <div>
                            <div
                                class="social-media-icon-holder h-[25px] w-[25px]"
                            >
                                <img class="w-[25px] h-[25px]" src="/storage/DESIGN/WORKSPACE/icons/tiktok-icon.png">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="p-1" >
            <li class="flex mt-[10px]">
                <lable class="p4 w-[80px] font-semibold text-grey-200 " >Projects:</lable>
                <p class="p3 text-grey-100 " >Projects:</p>
            </li>
            <li class="flex">
                <lable class="p4  w-[80px] font-semibold text-grey-200 " >Ratting:</lable>
                <p class="p4 pt-[2px]  text-grey-100 " >4.5</p>
            </li>

            <li class="holder flex align-bottom-c justify-end h-[40px]">
                <p4 class="text-grey-100" >Ksh 500/post</p4>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    name: 'Mobile-brand-Project-breakdown-Entry-component'
}
</script>
<style lang="scss" scoped>
@import './../../Pages/sassLoader';

.overlay{
    width: 100%;
    height: 150px;
    padding-bottom: 3px;
    background-image:linear-gradient(180deg, rgba(0, 0, 0, 0.17) 70%, rgba(0, 0, 0, 0.66)) ;
    p{
        width: 100%;
        height: fit-content;
        padding: 0px;
        margin: 0px;
    }
}

.icon-holder{
    width: 100%;
    height: 25px;

    &>div{
        &>div{
            border-radius: 50%;
            overflow: hidden;
        }
    }
}


@include s-screens {
    .card{
        width: 230px;
        .overlay{
            width: 230px;
        }

        .holder{
            &>img{
                width: 230px;
                height: 205px;
            }
        }
    }
}
</style>
