<script setup >
import {onMounted, reactive, ref} from "vue";
import * as pdfjsLib from 'pdfjs-dist';



const props = defineProps([
    'fileForm',
    'assignmentDetails'
])

const  assignmentDetails = reactive(props.assignmentDetails)

const data = reactive({
    'data':null
})
const pdf_display = ref([])

onMounted(async () => {
    for (const element of pdf_display.value) {
        try {
            const baseUrl = window.location.origin
            // Do something with the base URL, such as ma
            let url = element.getAttribute('data-file');
            let path = baseUrl+'/storage/'+url
            const encodedUrl = path.replace(/\s/g, '%20');

            // console.log(encodedUrl)
            //
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
            // Load the PDF document
            const pdf = await pdfjsLib.getDocument(encodedUrl).promise

            // Get the first page of the PDF
            const page = await pdf.getPage(1)

            // Set the viewport for the page
            const viewport = page.getViewport({ scale: 0.4 })
            const canvas = document.createElement('canvas')
            canvas.width = 280
            canvas.height = 300
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
        }
    }
})

function download(media){
    const url = `/storage/${media.path}`;
    const a = document.createElement('a');
    a.href = url;
    a.download = media.path.split('/').pop();
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}



</script>

<template>
    <div class="media-display">
        <div class="upload-section">
            <div class="input-group ">
                <input type="file" @input="data.data = $event.target.files[0]">
            </div>
            <button @click.prevent="$emit('uploadFile',data)">Upload</button>
        </div>
        <ul class="display-section mb-[80px]">
            <li v-for="media in assignmentDetails.assignment.media"  >
                <div v-if="media.type == 'image'" class="image-display">
                    <img :src="'/storage/'+media.path">
                    <div class="image-overlay">
                        <ul>
                            <li><button @click.prevent="download(media)">Download</button></li>
                            <li><button @click.prevent="$emit('DeleteMedia',media)">remove</button></li>
                        </ul>
                    </div>
                </div>
                <div v-if="media.type == 'PDF'" class="image-display">
                    <div class="pdf-display" :data-file="media.path" ref="pdf_display">

                    </div>
                    <div class="image-overlay">
                        <ul>
<!--                            <li><button @click.prevent="$emit('openModal',{-->
<!--                                type:'pdf',-->
<!--                                data:media-->
<!--                            })">View</button></li>-->
                            <li><button @click.prevent="download(media)">Download</button></li>
                            <li><button @click.prevent="$emit('DeleteMedia',media)">remove</button></li>
                        </ul>
                    </div>
                </div>
                <div v-if="media.type == 'video'" class="image-display flex items-center justify-between">
                    <video class="p-[10px]" style="height: 100%"   controls autoplay>
                        <source :src="'/storage/'+media.path">
                        Error Message
                    </video>
                    <div class="image-overlay">
                        <ul>
                            <li><button @click.prevent="download(media)">Download</button></li>
                            <li><button @click.prevent="$emit('DeleteMedia',media)">remove</button></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "mediaDispay"
}
</script>

<style lang="scss" scoped>
.media-display{
    width: 100%;
    height: 100%;
    .upload-section{
        margin-top: 10px;
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid lightgrey;
        .input-group{
            max-width: 200px;
            overflow: auto;
        }

        button{
            background-color: #cbd5e0;
            padding: 10px;
            margin-right: 10px;
            border-radius: 8px;
        }
    }

    .display-section{
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        padding: 10px;
        .image-display{
            width: 300px;
            height: 300px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 6px lightgrey;
            border-radius: 8px;
            position: relative;
            overflow: hidden;

            img{
                width: 100%;
                height: 100%;
                object-position: center;
                object-fit: contain;
            }

            .image-overlay{
                position: absolute;
                top: 0px;
                left: 0px;
                width: 100%;
                height: 100%;
                background-color: rgba(33, 33, 33, 0.66);
                opacity: 0;
                z-index: -100;
                transition: all ease-in 150ms;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: white;
            }

            button{
                border-radius: 8px;
                display: block;
                margin: 10px;
                border: 1px solid white;
                padding: 10px 20px;
                &:hover{
                    background-color: white;
                    color: black;
                }
            }

            &:hover{
                .image-overlay{
                    opacity: 1;
                    z-index: 300;
                }
            }
        }
        .pdf-display{
            width: 100%;
            height: 100%;
            background-color: #1a202c;
        }
    }
}
</style>
