<template>
    <div>
      <h2 style="margin-top: 30px;">User Manager</h2>
      <div style="margin-bottom: 20px;">
        <button @click="showArray=!showArray">Show Array</button>
        <br>
        <pre class="array" v-if="showArray">{{ userItems }}</pre>
      </div>
      <button class="newUser" @click="showUsers">New User</button>
      <div class="search">
        <!-- <FormKit type="search" placeholder="Search" Label="Search" v-model="searchQuery"></FormKit> -->
        <input type="text" v-model="searchQuery" placeholder="Search">
        <!-- <FormKit 
            type="select"
            v-model="sortOrder"
            :options="{
                asc: 'Ascending',
                desc: 'Descending'
            }"
        ></FormKit> -->
        <select v-model="sortOrder">
          <option value="asc">Ascending</option>
          <option value="desc">Descending</option>
        </select>
      </div>
      <div class="newUserInput" v-if="showNewUser">
        <input class="title" type="text" placeholder="First Name" v-model="newUser.firstName" :class="{ warning: emptyFields.firstName }">
        <input class="title" type="text" placeholder="Name" v-model="newUser.lastName" :class="{ warning: emptyFields.lastName }">
        <input class="title" type="email" placeholder="E-Mail" v-model="newUser.email" :class="{ warning: emptyFields.email || emailExists }">
        <input class="title" type="password" placeholder="Password" v-model="newUser.pwd" :class="{ warning: emptyFields.pwd }">
        <div class="editButtons">
          <button class="addUser" @click="addUser">Add User</button>
          <button class="closeUser" @click="showUsers">Close</button>
        </div>
      </div>
      <div class="user">
        <div v-for="(item, index) in searchResult" :key="index">
          <div v-if="editUser === item" class="userContent">
            <div>
                <div>
                    <div class="inputField">
                        <input type="text" id="firstName" v-model="editedUser.firstName" :class="{ 'error-input': isFirstNameEmpty }">
                        <label for="firstName">First Name</label>
                    </div>
                    <div class="inputField">
                        <input type="text" id="lastName" v-model="editedUser.lastName" :class="{ 'error-input': isLastNameEmpty }">
                        <label for="lastName">Last Name</label>
                    </div>
                    <div class="inputField">
                        <input type="email" id="email" v-model="editedUser.email" :class="{ 'error-input': isEmailEmpty }">
                        <label for="email">Email</label>
                    </div>
                    <div class="inputField">
                        <input type="text" id="pwd" v-model="editedUser.pwd" :class="{ 'error-input': isPasswordEmpty }">
                        <label for="pwd">Password</label>
                    </div>
                </div>
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
            showNewUser: false,
            showArray: false,
            editedUser: {
                firstName: '',
                lastName: '',
                email: '',
                pwd: '',
            },
            newUser: {
                firstName: '',
                lastName: '',
                email: '',
                pwd: '',
            },
            emptyFields: {
                firstName: false,
                lastName: false,
                email: false,
                pwd: false,
            },
            emailExists: false,
            errors: {},
            userItems: [],
            editUser: null,
        }
    },
    created() {
        this.getUsers()
    },
    methods: {
        userExists(email) {
            return this.userItems.some(user => user.email === email)
        },
        async getUsers() {
            try {
                const response = await axios.get('http://localhost:10000/get-user')
                console.log(response.data)
                if (typeof response.data === 'object' && response.data !== null) {
                    this.userItems = Object.keys(response.data).map(key => ({
                        id: key,
                        ...response.data[key],
                    }))
                } else {
                    console.error('Response data is not an object')
                }
            } catch (error) {
                console.error(error)
            }
        },
        showUsers() {
            this.newUser = {
                firstName: '',
                lastName: '',
                email: '',
                pwd: '',
            }
            this.editUser = null
            this.showNewUser = !this.showNewUser
            this.emailExists = false
        },
        async addUser() {
            this.emptyFields = {
                firstName: !this.newUser.firstName,
                lastName: !this.newUser.lastName,
                email: !this.newUser.email,
                pwd: !this.newUser.pwd,
            }
            if (Object.values(this.emptyFields).includes(true)) {
                return
            }
            if (this.userExists(this.newUser.email)) {
                this.emailExists = true
                this.errors.email = 'Email already exists'
                return
            } else {
                this.emailExists = false
            }
            this.editUser = null
            if (this.newUser.firstName && this.newUser.lastName && this.newUser.email && this.newUser.pwd) {
                try {
                    await axios.post('http://localhost:10000/add-user', this.newUser)
                    this.getUsers()
                } catch (error) {
                    console.error(error)
                }
                this.newUser = {
                    firstName: '',
                    lastName: '',
                    email: '',
                    pwd: '',
                }
                this.editUser = null
                this.showNewUser = false
            }
            },

        editUserIndex(index) {
            this.editUser = this.searchResult[index]
            this.editedUser = {
                id: this.editUser.id,
                firstName: this.editUser.firstName,
                lastName: this.editUser.lastName,
                email: this.editUser.email,
                pwd: this.editUser.pwd,
            }
        },
        async saveUser() {
            if(this.editUser !== null) {
                this.errors = {};
                if (!this.editedUser.firstName) this.errors.firstName = 'First Name cannot be empty'
                if (!this.editedUser.lastName) this.errors.lastName = 'Last Name cannot be empty'
                if (!this.editedUser.email) this.errors.email = 'Email cannot be empty'
                if (!this.editedUser.pwd) this.errors.pwd = 'Password cannot be empty'
                if (this.editedUser.firstName && this.editedUser.lastName && this.editedUser.email && this.editedUser.pwd) {
                    try {
                        const response = await axios.post(`http://localhost:10000/update-user/${this.editedUser.id}`, this.editedUser);
                        console.log("Received response", response);
                        this.getUsers();
                    } catch (error) {
                        console.log("Error occurred while sending request", error);
                    }
                    this.editUser = null;
                    this.editedUser = {
                        id: '',
                        firstName: '',
                        lastName: '',
                        email: '',
                        pwd: '',
                    }
                }
            }
        },
        async deleteUser() {
            if(this.editUser !== null) {
                try {
                    await axios.delete(`http://localhost:10000/delete-user/${this.editedUser.id}`)
                    console.log(`http://localhost:10000/delete-user/${this.editedUser.id}`)
                    this.getUsers()
                } catch (error) {
                    console.error(error)
                }
            }
            this.editUser = null
            this.editedUser = {
                id: '',
                firstName: '',
                lastName: '',
                email: '',
                pwd: '',
            }
        },
    },
    computed: {
        searchResult() {
            let sortedUsers = [...this.userItems]
            if (this.searchQuery) {
                this.editUser = null
                sortedUsers = sortedUsers.filter(item =>
                    (item.firstName && item.firstName.toLowerCase().includes(this.searchQuery.toLowerCase())) ||
                    (item.lastName && item.lastName.toLowerCase().includes(this.searchQuery.toLowerCase()))
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
        },
        isFirstNameEmpty() {
            return this.editedUser.firstName === '';
        },
        isLastNameEmpty() {
            return this.editedUser.lastName === '';
        },
        isEmailEmpty() {
            return this.editedUser.email === '';
        },
        isPasswordEmpty() {
            return this.editedUser.pwd === '';
        },
    },
}
</script>
<style>
    .title {
        margin: 10px 0 10px;
        background-color: darkslategray;
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
    .inputField {
        position: relative;
        margin-bottom: 20px;
    }
    .inputField input {
        width: 100%;
        padding: 10px;
        padding-left: 80px;
    }
    .inputField label {
        position: absolute;
        left: 5px;
        top: -66%;
        background-color: #122020;
        border: 1px solid darkslategray;
        border-radius: 5px;
        transform: translateY(-50%);
        padding: 0 5px;
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
    .error-input, .warning {
        border: 1px solid #ff5555 !important;
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
    .array {
        text-align: left; 
        margin: 20px 250px;
        padding: 10px;
        background-color: rgba(47, 79, 79, 0.5);
        border-radius: 7px;
    }
</style>