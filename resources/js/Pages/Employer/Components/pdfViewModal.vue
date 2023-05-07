<script setup>
import {onMounted, ref} from "vue";
import * as pdfjsLib from "pdfjs-dist";

const props = defineProps([
    'media'
])
const pdf_display = ref()

onMounted(async () => {
    try {
        const baseUrl = window.location.origin
        // Do something with the base URL, such as ma
        let element = pdf_display.value
        let url = element.getAttribute('data-file');
        let path = baseUrl + '/storage/' + url
        const encodedUrl = path.replace(/\s/g, '%20');

        // console.log(encodedUrl)
        //
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
        // Load the PDF document
        const pdf = await pdfjsLib.getDocument(encodedUrl).promise

        // Get the first page of the PDF
        const page = await pdf.getPage(1)

        // Set the viewport for the page
        const viewport = page.getViewport({scale: 0.5})
        const canvas = document.createElement('canvas')
        canvas.width = 300
        canvas.height = 500
        const context = canvas.getContext('2d')

        // Render the first page of the PDF to the canvas
        const renderContext = {
            canvasContext: context,
            viewport: viewport
        }
        await page.render(renderContext).promise

        // Set the canvas as the display element's content
        element.appendChild(canvas)
    } catch (error) {
        console.log(error)
    }
})

</script>

<template>
    <div class="image-display">
        <div class="image-section">
            <div class="header-section">
                <p @click.prevent="$emit('closeModel')">X</p>
            </div>
            <div class="body">
                <div class="pdf-view">
                    <div ref="pdf_display" :data-file="media.data.path">

                    </div>
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

<style scoped lang="scss">
.image-display {
    height: 100%;
    width: 1000px;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: center;

    .image-section {
        overflow: hidden;
        height: 80%;
        background-color: white;

        .header-section {
            width: 100%;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: flex-end;

            p {
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

        .body {
            width: 100%;
            height: calc(100% - 90px);
        }

        .footer {
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px -2px 4px lightgrey;
            z-index: 300;

            button {
                width: 100px;
                height: 40px;
                margin: 0px 10px;
                border: 1px solid orange;
                color: orange;
                border-radius: 3px;

                &:active {
                    background-color: orange;
                    color: white;
                }
            }
        }
    }
}

.body {
    z-index: 100;
    .pdf-view {
        overflow: auto;
        height: 90%;
        display: flex;
        justify-content: center;
    }
}
</style>
