<template>
    <div class="container">
        <div class="large-12 medium-12 small-12 cell">
            <h1>Image Upload using Vue and PHP</h1>
            <label>File
                <input type="file" id="file" ref="file" @change="onChangeFileUpload()"/>
            </label>
            <br>
            <button class="upload_button" v-if="!loading" @click="submitForm()">Upload</button>
        </div>
        <div v-if="loading" class="spinner"></div>
    </div>
</template>
  
<script>
    export default {
        data() {
            return {
                file: '',
                loading: false,
            }
        },

        methods: {
            submitForm() {
                if (!this.file) {
                    console.error("No file selected!")
                    return
                }
                this.loading = true
                let formData = new FormData()
                let blob = this.file.slice(0, this.file.size, this.file.type)
                let newFile = new File([blob], Date.now() + '.' + this.file.type.split('/').pop())
                formData.append('file', newFile)
                this.axios.post(
                    'http://localhost:10000/add-file',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                .then((data) => {
                    this.loading = false
                    console.log(data.data)
                    this.$refs.file.value = ""
                    this.file = null
                })
                .catch((error) => {
                    this.loading = false
                    console.log('Failure', error)
                })
            },
            onChangeFileUpload() {
                this.file = this.$refs.file.files[0]
            }
        }
    }
</script>
<style>
.upload_button {
    padding: 7px;
    font-size: 20px;
}
.spinner {
    margin: auto;
    margin-bottom: -1px;
    border: 4px solid #22374d; 
    border-radius: 50%; 
    border-top: 4px solid #92b5e0; 
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>