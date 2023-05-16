<template lang="">
    <div>
        <h3>{{ scoreMsg }}</h3>
    </div>
</template>
<script>
export default {
    
    props: ['score'],
    computed: {
        scoreMsg() {
            if (this.score > 0) {
            return "your reaction time time is " + this.score + "ms"
        } else {
            return "too soon!"
        }
        }
    }
}
</script>
<style lang="">
    
</style>