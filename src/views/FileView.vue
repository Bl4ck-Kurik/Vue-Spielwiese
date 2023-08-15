<template>
    <div>
        <FileUploadV2 :settings="FileSettings"/>
        <div style="height: 50px;"></div>
        <Gallery/>
        <!-- <FileUpload/> -->
    </div>
</template>
<script>
import FileUpload from '@/components/FileUpload.vue'
import FileUploadV2 from '@/components/FileUpload_v2.vue'
import Gallery from '@/components/Gallery.vue'

export default {
    data() {
        return {
            FileSettings: {
                type: 'image doc',
                size: 4,
                mime: ['image/png', 'application/pdf'],
                // endpointURL: 'http://test.test/test',
                // msgType: 'Nur Videos (MP4)!',
                // msgSize: 'Nicht größer als 100MB!'
            }
        }
    },
    components: {
        FileUpload,
        FileUploadV2,
        Gallery,
    } 
}
</script>
<style>
    
</style>