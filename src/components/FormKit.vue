<script setup>
    import { ref } from 'vue'
    const formData = ref({
            username: "kurik",
            password: ""
    })
</script>
<template>
    <div class="formkit">
        <FormKit 
        type="form" 
        submit-label="Login"
        :value="formData" @submit="handleSubmit">
            <h1>Login</h1>
            <FormKit type="text" label="Username" name="username" validation="required"/>
            <FormKit type="password" label="Password" name="password" validation="required"/>
        </FormKit>
        <FormKit 
        type="form" 
        submit-label="Login"
        :actions="false"
        :value="formData" @submit="handleSubmit">
            <template #default="{ state }">
                <h1>Login</h1>
                <FormKit type="text" label="Username" name="username" />
                <FormKit type="password" label="Password" name="password" />
                <button :disabled="state.loading">
                    {{ state.loading ? "Loading..." : "Login" }}
                </button>
            </template>
            
        </FormKit>
    </div>
</template>
<script>
export default {
    data() {
        return {
            sharedMethods: {
                wait: function(ms) {
                    return new Promise((resolve) => setTimeout(resolve, ms));
                }
            }
        }
    },
    methods: {
        async handleSubmit(data) {
            await this.sharedMethods.wait(3000);
            console.log(data);
        }
    },
}
</script>
<style>
    .formkit .formkit-wrapper {
        margin: auto;
    }
</style>