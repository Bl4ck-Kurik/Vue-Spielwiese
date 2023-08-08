<template>
    <div>
        <FileUploadV2/>
        <div style="height: 50px;"></div>
        <Gallery/>
        <!-- <FileUpload/> -->
    </div>
</template>
<script>
import FileUpload from '@/components/FileUpload.vue';
import FileUploadV2 from '@/components/FileUpload_v2.vue';
import Gallery from '@/components/Gallery.vue';

export default {
    components: {
        FileUpload,
        FileUploadV2,
        Gallery,
    } 
}
</script>
<style>
    
</style>