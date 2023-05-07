<script setup>
</script>

<template>
    <div class="holder active" style="border-radius: 5px; overflow: hidden;">
        <div class="image">
            <img src="/storage/uploads/user.jpg" alt="">
        </div>
        <div class="heading flex items-end">
            <p class="p3  text-grey-200">Username</p>
        </div>
        <div class="message">
            <p class="p4 text-grey-200" >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto, asperiores consectetur dicta dolor ex fuga, impedit inventore ipsa laboriosam nemo nostrum provident quam quasi quis quo repellendus, voluptatem voluptatum.</p>
        </div>
        <div class="time">
            <p class="p4 text-grey-200" >12:30pm 3/3/2023</p>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import './../../Pages/sassLoader';

.holder{
    background-color: var(--light-grey);
    height: 80px;
    display: grid;
    grid-template-areas:
    "image title"
    "image message"
    "image time";

    grid-template-columns: 60px 1fr;
    grid-template-rows: 1fr 1fr 1fr;

    .image{
        width: 100%;
        height: 100%;
        grid-area: image;
        @include flex-center;

        img{
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    }

    .message{
        width: 90%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .time{
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
        padding: 3px;
    }


}

.active{
    background-color: var(--t-purple);
    & *{
        color: white;
    }
}

@include s-screens {

}
</style>
