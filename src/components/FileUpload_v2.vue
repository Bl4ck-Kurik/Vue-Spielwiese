<template>
    <div class="container">
        <div class="large-12 medium-12 small-12 cell">
            <h1>Image Upload using Vue and PHP</h1>
            <pre>{{ settings }}</pre>
            <div class="inputWrapper" :class="{ pseudoWarning: warnings.size || warnings.type}" :style="{ '--content': `'${pseudoContent}'` }">
                <input type="file" id="file" class="uploadInput" :class="{ warning: warnings.size || warnings.type}" ref="file" @change="onChangeFileUpload()"/>
            </div>
            <br>
            <button class="uploadButton" :disabled='warnings.size || warnings.type' v-if="!loading" @click="submitForm()">Upload</button>
        </div>
        <div v-if="loading" class="spinner"></div>
    </div>
</template>
  
<script>
    import EventBus from "@/utils/EventBus"

    export default {
        data() {
            return {
                file: '',
                fileSize: null,
                loading: false,
                pseudoContent: '',
                warnings: {
                    size: false,
                    type: false,
                }
            }
        },
        props: {
            settings: {
                type: Object,
                required: true,
                default: function () {
                    return { type: 'image', mime: [], size: 2, endpointURL: '', msgType: '', msgSize: ''}
                },
                validator: function (value) {
                    if (typeof value !== 'object') return false
                    
                    if (!value.type) value.type = 'image'
                    if (!value.mime) value.mime = []
                    if (!value.size) value.size = 2
                    if (!value.endpointURL) value.endpointURL = ''
                    if (!value.msgType) value.msgType = ''
                    if (!value.msgSize) value.msgSize = ''

                    return (
                        typeof value.type === 'string' &&
                        Array.isArray(value.mime) &&
                        typeof value.size === 'number' &&
                        typeof value.endpointURL === 'string' &&
                        typeof value.msgType === 'string' &&
                        typeof value.msgSize === 'string'
                    )
                }
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
                let endpoint = ''
                if (!this.settings.endpointURL) {
                    endpoint = 'http://localhost:10000/addfile'
                } else {
                    endpoint = this.settings.endpointURL
                }
                this.axios.post(endpoint, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                .then((data) => {
                    this.loading = false
                    console.log(data)
                    this.$refs.file.value = ""
                    this.file = null
                    EventBus.emit('fileUploaded')
                })
                .catch((error) => {
                    this.loading = false
                    console.log('Failure', error)
                })
            },
            onChangeFileUpload() {
                this.warnings.size = false
                this.warnings.type = false
                const selectedFile = this.$refs.file.files[0]
                if (!selectedFile) return 
                let allowedTypes = []
                if (!this.settings.mime) {
                    if (this.settings.type.includes('image')) {
                        allowedTypes = [...allowedTypes, 'image/jpeg', 'image/png']
                    }
                    if (this.settings.type.includes('doc')) {
                        allowedTypes = [...allowedTypes, 'application/pdf']
                    }
                } else {
                    allowedTypes = [...this.settings.mime]
                }
                if (!allowedTypes.includes(selectedFile.type)) {
                    this.warnings.type = true
                    const formattedTypes = allowedTypes.map(type => {
                        return type.split('/').pop().toUpperCase()
                    }).join(', ')
                    if (!this.settings.msgType) {
                        this.pseudoContent = 'Invalid file type! Please upload an ' + formattedTypes + '.'
                    } else {
                        this.pseudoContent = this.settings.msgType
                    }
                    console.error("Invalid file type!")
                    this.file = null
                    return
                }
                const sizeInMB = (selectedFile.size / 1_048_576).toFixed(2)
                if (parseFloat(sizeInMB) >= this.settings.size) {
                    this.warnings.size = true
                    if (!this.settings.msgSize) {
                        this.pseudoContent = 'File cant be larger than ' + this.settings.size + 'MB!'
                    } else {
                        this.pseudoContent = this.settings.msgSize
                    }
                    console.error("File is too big!")
                    this.file = null
                    return
                }
                this.file = selectedFile;
                this.fileSize = `${sizeInMB} MB`
            }
        }
    }
</script>
<style>
.uploadButton {
    padding: 7px;
    font-size: 20px;
}
.inputWrapper {
    max-width: 400px;
    margin: auto;
}
.pseudoWarning {
    position: relative;
}
.pseudoWarning::after {
    content: var(--content);
    position: absolute;
    top: 44px; 
    left: 0; 
    color: #ff5555;
    font-size: 12px;
    white-space: nowrap;
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
.warning {
    border: 1px solid #ff5555 !important;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>