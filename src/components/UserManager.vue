<template>
    <div>
        <h2 style="margin-top: 30px;">User Manager</h2>
        <button class="newUser" @click="showUsers">New User</button>
        <div class="search">
            <input type="text" v-model="searchQuery" placeholder="Search">
            <select v-model="sortOrder">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
        <div v-if="newUser" class="newUserInput">
            <input class="title" type="text" placeholder="First Name" v-model="newUserFirstName">
            <input class="title" type="text" placeholder="Name" v-model="newUserLastName">
            <input class="title" type="email" placeholder="E-Mail" v-model="newUserEmail">
            <input class="title" type="password" placeholder="Password" v-model="newUserPassword">
            <div class="editButtons">
                <button class="addUser" @click="addUser">Add User</button>
                <button class="closeUser" @click="showUsers">Close</button>
            </div>
        </div>
        <div class="user">
            <div v-for="(item, index) in searchResult" :key="index">
                <div v-if="editUser === item" class="userContent">
                    <div>
                        <input type="text" v-model="editedFirstName">
                        <input type="text" v-model="editedLastName">
                        <input type="email" v-model="editedEmail">
                        <input type="text" v-model="editedPassword">
                    </div>
                    <div class="userButtons">
                        <div>
                            <button @click="saveUser" class="saveUser">Save</button>
                            <button @click="this.editUser = null" class="closeUser">Close</button>
                        </div>    
                        <button @click="deleteUser" class="deleteUser">Delete</button>
                    </div>
                </div>
                <div v-else @click="editUserIndex(index)" class="userContent">
                    <h3>{{ item.firstName }} {{ item.lastName }}</h3>
                    <p>{{ item.email }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            searchQuery: '',
            sortOrder: 'asc',
            editUser: null,
            editedFirstName: '',
            editedLastName: '',
            editedEmail: '',
            editedPassword: '',
            newUser: false,
            newUserFirstName: '',
            newUserLastName: '',
            newUserEmail: '',
            newUserPassword: '',
            userItems: [],
        }
    },
    created() {
        this.getUsers()
    },
    methods: {
        async getUsers() {
            try {
                const response = await axios.get('http://localhost:10000/get-user')
                console.log(response.data) // Log the response data
                if (Array.isArray(response.data)) {
                    this.userItems = response.data
                } else {
                    console.error('Response data is not an array')
                }
            } catch (error) {
                console.error(error)
            }
        },
        showUsers () {
            this.newUser = !this.newUser
            this.editUser = null
        },
        async addUser () {
            this.editUser = null
            if (this.newUserFirstName && this.newUserLastName) {
                try {
                    await axios.post('http://localhost:10000/add-user', {
                        firstName: this.newUserFirstName,
                        lastName: this.newUserLastName,
                        email: this.newUserEmail,
                        pwd: this.newUserPassword,
                    })
                    this.getUsers()
                } catch (error) {
                    console.error(error)
                }
                this.newUser = false
                this.newUserFirstName = ''
                this.newUserLastName = ''
                this.newUserEmail = ''
                this.newUserPassword = ''
                this.editUser = null
            }
        },
        editUserIndex(index) {
            this.editUser = this.searchResult[index]
            let originalIndex = this.userItems.indexOf(this.editUser)
            this.editedFirstName = this.userItems[originalIndex].firstName
            this.editedLastName = this.userItems[originalIndex].lastName
            this.editedEmail = this.userItems[originalIndex].email
            this.editedPassword = this.userItems[originalIndex].pwd
        },
        async saveUser() {
            if(this.editUser !== null) {
                let originalIndex = this.userItems.indexOf(this.editUser)
                try {
                    await axios.put(`http://localhost:10000/update-user/${originalIndex}`, {
                        firstName: this.editedFirstName,
                        lastName: this.editedLastName,
                        email: this.editedEmail,
                        pwd: this.editedPassword,
                    })
                    this.getUsers()
                } catch (error) {
                    console.error(error)
                }
            }
            this.editUser = null
            this.editedFirstName = ''
            this.editedLastName = ''
            this.editedEmail = ''
            this.editedPassword = ''
        },
        async deleteUser() {
            if(this.editUser !== null) {
                let originalIndex = this.userItems.indexOf(this.editUser)
                try {
                    await axios.delete(`http://localhost:10000/delete-user/${originalIndex}`)
                    this.getUsers()
                } catch (error) {
                    console.error(error)
                }
            }
            this.editUser = null
            this.editedFirstName = ''
            this.editedLastName = ''
            this.editedEmail = ''
            this.editedPassword = ''
        },
    },
    computed: {
        searchResult() {
            let sortedUsers = [...this.userItems]
            if (this.searchQuery) {
                this.editUser = null
                sortedUsers = sortedUsers.filter(item =>
                    item.firstName && item.firstName.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
            }
            if (this.sortOrder === 'asc') {
                this.editUser = null
                sortedUsers = sortedUsers.sort((a, b) => {
                    if (a.firstName && b.firstName) {
                        return a.firstName.localeCompare(b.firstName)
                    }
                    return 0;
                })
            } else if (this.sortOrder === 'desc') {
                this.editUser = null
                sortedUsers = sortedUsers.sort((a, b) => {
                    if (a.firstName && b.firstName) {
                        return b.firstName.localeCompare(a.firstName)
                    }
                    return 0;
                })
            }
            return sortedUsers
        }
    },
}
</script>
<style>
    .title {
        margin: 10px 0 10px;
    }
    .newUser, .addUser, .saveUser, .closeUser, .deleteUser, .closeUser {
        font-size: 17px;
        padding: 10px;
    }
    .newUser {
        margin-bottom: 10px;
        width: 700px;
    }
    .newUserInput {
        margin-bottom: 20px;
        width: 700px;
        margin: auto;
    }
    .addUser {
        margin-top: 20px;
    }
    .saveUser, .closeUser, .deleteUser {
        margin-top: 10px;
    }
    .saveUser, .closeUser {
        align-items: start;
        justify-content: lefts;
    }
    .deleteUser {
        color: #5e0101;
        background-color: #ff5555;
    }
    .saveUser, .addUser {
        color: rgb(1, 54, 1);
        background-color: rgb(125, 223, 125);
    }
    .user {
        margin-top: 20px;
    }
    .user h3, .user p, .user input, .user textarea {
        background-color: rgba(47, 79, 79, 0.288);
        border: 1px solid darkslategray;
        border-radius: 7px;
        margin: 0;
        text-align: left;
        padding: 10px;
        word-wrap: break-word;
    }
    .user input, .user textarea {
        width: 670px;
    }
    .user p, .user h3 {
        width: 648px;
    }
    .user h3, .user input {
        margin-bottom: 5px;
    }
    .user li, .userContent {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        flex-wrap: wrap;
        width: 700px;
        padding: 15px 0 15px;
        margin: 10px auto 10px auto;
        background-color: rgba(47, 79, 79, 0.15);
        border-radius: 7px;
    }
    .userButtons {
        display: flex;
        justify-content: space-between;
        width: 670px;
    }
    .search {
        display: flex;
        margin: 0 auto 10px auto;
        width: 700px;
    }
    .search input {
        margin-right: 10px;
    }
    .search select {
        width: 20%;
    }
</style>