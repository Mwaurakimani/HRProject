<script setup>
const props = defineProps([
    'media'
])
</script>

<template>
    <div class="image-display">
        <div class="image-section">
            <div class="header-section">
                <p @click.prevent="$emit('closeModel')">X</p>
            </div>
            <div class="body">
                <div class="image-view">
                    <img :src="'/storage/'+media.data.path">
                </div>
            </div>
            <div class="footer">
                <button @click.prevent="$emit('download',props.media.data.path)">Download</button>
                <button @click.prevent="$emit('DeleteMedia',props.media.data)">remove</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ImageViewModal"
}
</script>

<style scoped lang="scss" >
.image-display{
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    .image-section{
        overflow: hidden;
        width: 90%;
        height: 80%;
        background-color: white;
        .header-section{
            width: 100%;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: flex-end;

            p{
                width: 20px;
                height: 20px;
                background-color: red;
                color: white;
                text-align: center;
                border-radius: 50%;
                margin-right: 10px;
                cursor: pointer;
            }
        }

        .body{
            width: 100%;
            height: calc(100% - 90px);
        }
        .footer{
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px -2px 4px lightgrey;
            button{
                width: 100px;
                height: 40px;
                margin: 0px 10px;
                border: 1px solid orange;
                color: orange;
                border-radius: 3px;
                &:active{
                    background-color: orange;
                    color: white;
                }
            }
        }
    }
}

.body{
    .image-view{
        height: 100%;
        overflow: hidden;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        img{
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    }
}
</style>
