<template>
    <div v-if="imageLarge.state" @click="imageLarge.state = false" class="image-large">
        <img :src="imageLarge.url">
    </div>
    <div class="image-gallery">
        <div @click="openFile(url)" v-for="url in imageUrls" :key="url" class="image-wrapper">
            <img :src="url" alt="Image" />
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            imageUrls: [],
            imageLarge: {
                state: false,
                url: ''
            }
        }
    },
    methods: {
        openFile(clickedUrl) {
            this.imageLarge.state = true
            this.imageLarge.url = clickedUrl
        },
        reloadFiles() {
            axios.get('http://localhost:10000/listfiles')
            .then(response => {
                console.log(response)
                this.imageUrls = response.data
            })
            .catch(error => {
                console.error('Error fetching the images:', error)
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
    }
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
        align-items: center;    
        justify-content: center;
    }
    .image-large img {
        max-width: 1420px;
        max-height: 580px;
    }
</style>