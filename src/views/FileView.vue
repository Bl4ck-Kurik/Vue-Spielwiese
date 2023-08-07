<template>
    <div>
        <FileUploadV2/>
        <div style="height: 50px;"></div>
        <!-- <FileUpload/> -->
    </div>
</template>
<script>
import FileUpload from '@/components/FileUpload.vue';
import FileUploadV2 from '@/components/FileUpload_v2.vue';

export default {
    components: {
        FileUpload,
        FileUploadV2,
    } 
}
</script>
<style>
    
</style>