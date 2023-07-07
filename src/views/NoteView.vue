<template>
    <button @click="toggle">Toggle</button>
    <div v-if="!toggleComponents">
        <UserManager/>
    </div>
    <div v-else>
        <NoteList/>
    </div>
</template>
<script>
    import NoteList from '@/components/NoteList.vue'
    import UserManager from '@/components/UserManager.vue'
    
    export default {
        data() {
            return {
                toggleComponents: false,
            }
        },
        methods: {
            toggle() {
                this.toggleComponents = !this.toggleComponents
            }
        },
        components: {
            NoteList,
            UserManager,
        },
    }
</script>