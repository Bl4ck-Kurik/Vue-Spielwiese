<template>
    <div>
        <input type="file" @change="uploadFile" ref="file">
        <button @click="submitFile">Upload!</button>
        <div v-if="imageURL">
            <img :src="imageURL" alt="Uploaded content" />
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            selectedFile: null,
            imageURL: null,
        }
    },
    methods: {
        uploadFile(event) {
            this.selectedFile = event.target.files[0]
        },
        async submitFile() {
            const formData = new FormData()
            formData.append('file', this.selectedFile)
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            try {
                const response = await axios.post('http://localhost:10000/add-file', formData, config)
                this.imageURL = response.data.fileURL;
                console.log(response)
                console.log(response.data.fileURL)
            } catch (error) {
                console.error("There was a problem uploading the file:", error)
            }
        }
    },
}
</script>
<style>
    
</style>
