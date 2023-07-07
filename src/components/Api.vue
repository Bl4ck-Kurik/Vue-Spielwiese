<template>
    <div>
        <div>
            <input type="text" v-model="newUser.name" placeholder="name">
            <input type="text" v-model="newUser.surname" placeholder="surname">
            <button @click="addUser">submit</button>
        </div>
        <div v-for="(item, index) in users" :key="index">
            <p>{{ item.id }}</p>
            <h3>{{ item.name }} {{ item.surname }}</h3>
            <p>{{ item.last-modified }}</p>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
  data() {
    return {
      users: {},
    };
  },
  methods: {
    getUsers() {
      axios
        .get('http://localhost:10000/get-user')
        .then(response => (this.users = response.data))
        .catch(error => console.error(error))
    },
    addUser(newUser) {
      axios
        .post('http://localhost:10000/add-user', newUser)
        .then(response => {
          // If the addition is successful, we might want to update our user list
          this.getUsers();
        })
        .catch(error => console.error(error))
    },
    updateUser(userId, updatedData) {
      axios
        .put(`http://localhost:10000/update-user/${userId}`, updatedData)
        .then(response => {
          // If the update is successful, we might want to update our user list
          this.getUsers();
        })
        .catch(error => console.error(error))
    },
  },
  created() {
    this.getUsers()
  },
};
</script>
<style>
    
</style>