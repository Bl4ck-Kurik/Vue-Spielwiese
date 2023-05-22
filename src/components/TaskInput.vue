<template lang="">
    <div>
        <input v-model="newTaskText" type="text" placeholder="Hier Text Eingeben!">
        <button @click="addTask">Hinzufügen</button>        
    </div>
</template>
<script>
export default {
    data() {
        return {
            newTaskText: ''
        }
    },
    methods: {
        addTask () {
            const newtask = {
                text: this.newTaskText,
                completet: false
            };
            this.$emit('task-added', newTask);
            this.newTaskText= ''
        }
    },
}
</script>
<style lang="">
    
</style>