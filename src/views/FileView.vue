<template>
    <div>
        <FileUploadV2 :settings="FileSettings"/>
        <div style="height: 50px;"></div>
        <Gallery/>
        <PdfViewer v-if="pdfLoaded" :src="pdfs"/>
        <!-- <FileUpload/> -->
    </div>
</template>
<script>
import FileUpload from '@/components/FileUpload.vue'
import FileUploadV2 from '@/components/FileUpload_v2.vue'
import Gallery from '@/components/Gallery.vue'
import PdfViewer from '@/components/PdfViewer.vue'
import axios from 'axios'

export default {
    data() {
        return {
            FileSettings: {
                type: 'image doc',
                size: 2,
                // mime: ['image/png', 'application/pdf'],
                // endpointURL: 'http://test.test/test',
                // msgType: 'Nur Videos (MP4)!',
                // msgSize: 'Nicht größer als 100MB!'
            },
            pdfs: [],
            pdfLoaded: false
        }
    },
    mounted() {
        axios.get('http://localhost:10000/listpdf')
            .then(response => {
                console.log(response)
                this.pdfs = response.data
                this.pdfLoaded = true
            })
            .catch(error => {
                console.error('Error fetching the PDFs:', error)
            })
    },
    components: {
        FileUpload,
        FileUploadV2,
        Gallery,
        PdfViewer
    } 
}
</script>
<style>
    
</style>