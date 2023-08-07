<template>
    <div class="container">
      <div class="large-12 medium-12 small-12 cell">
        <h1>Image Upload using Vue and PHP</h1>
        <label>File
          <input type="file" id="file" ref="file" @change="onChangeFileUpload()" />
        </label>
        <button @click="submitForm()">Upload</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        file: ''
      };
    },
  
    methods: {
      submitForm() {
        let formData = new FormData();
        formData.append('file', this.file);
  
        this.axios.post(
          'http://localhost:10000/add-file',
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        )
        .then(function(data){
          console.log(data.data);
        })
        .catch(function(error){
          console.log('FAILURE!!', error);
        });
      },
  
      onChangeFileUpload() {
        this.file = this.$refs.file.files[0];
      }
    }
  }
  </script>
  