<template>
    <div v-if="imageLarge.state" @click="imageLarge.state = false, deleteButton=false" class="image-large">
        <img :src="imageLarge.url">
        <button class="large-button red" v-if="!deleteButton" @click.stop="deleteButton=true">Delete</button>
        <div class="deleteButtons" v-if="deleteButton">
            <button @click="deleteFile" class="large-button red">Delete</button>
            <button @click.stop="deleteButton=false" class="large-button">Cancel</button>
        </div>
    </div>
    <div class="image-gallery">
        <div @click="openFile(url)" v-for="url in imageUrls" :key="url" class="image-wrapper">
            <img :src="url" alt="Image" />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import EventBus from "@/utils/EventBus"

export default {
    data() {
        return {
            imageUrls: [],
            imageLarge: {
                state: false,
                url: ''
            },
            deleteButton: false
        }
    },
    methods: {
        openFile(clickedUrl) {
            this.imageLarge.state = true
            this.imageLarge.url = clickedUrl
        },
        reloadFiles() {
            console.log('Files Reloading...')
            axios.get('http://localhost:10000/listfiles')
            .then(response => {
                console.log(response)
                this.imageUrls = response.data
            })
            .catch(error => {
                console.error('Error fetching the images:', error)
            })
        },
        deleteFile() {
            let filename = this.imageLarge.url.split('/').pop();
            axios.delete(`http://localhost:10000/deletefile/${filename}`)
            .then(response => {
                this.deleteButton = false
                this.reloadFiles()
                console.log(response.data)
            })
            .catch(error => {
                console.error("Error deleting file:", error);
            })
        }
    },
    mounted() {
        axios.get('http://localhost:10000/listfiles')
        .then(response => {
            console.log(response)
            this.imageUrls = response.data
        })
        .catch(error => {
            console.error('Error fetching the images:', error)
        })
        EventBus.on('fileUploaded', this.reloadFiles)
    },
    beforeUnmount() {
        EventBus.off('fileUploaded', this.reloadFiles)
    },
}
</script>

<style>
    .image-wrapper {
        display: inline-block;
        margin-bottom: 5px;
    }
    .image-wrapper img {
        width: 200px;
        height: 200px;
        margin: 0 5px;
        border: solid 5px darkslategray;
        background: white;
        object-fit: cover;
    }
    .image-large {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.7);
        z-index: 1000;
        vertical-align: middle;
        display: flex;
        flex-direction: column;
        align-items: center;    
        justify-content: center;
    }
    .deleteButtons {
        position: relative;
    }
    .deleteButtons::before {
        content: "Are you sure?";
        display: block;
        position: absolute;
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        top: -23px;
    }
    .image-large img {
        max-width: 1420px;
        max-height: 580px;
        margin-bottom: 30px;
    }
</style>