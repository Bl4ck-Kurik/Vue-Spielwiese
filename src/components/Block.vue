<template>
    <div class="block" v-if="showBlock" @click="stopTimer">Click me</div>
    <div class="block-red" v-if="!showBlock" @click="stopTimer">Click when green!</div>
</template>
<script>
export default {
    props: ['delay'],
    data() {
        return {
            showBlock: false,
            timer: null,
            reactionTime: 0
        }
    },
    mounted() {
        setTimeout(() => {
            this.showBlock = true
            this.startTimer()
        },  this.delay)
    },
    methods: {
        startTimer () {
            this.timer = setInterval(() => {
                this.reactionTime += 10
            }, 10)
        },
        stopTimer () {
            clearInterval(this.timer)
            this.$emit('end', this.reactionTime)
        },
    },
}
</script>
<style>
    .block {
        width: 400px;
        border-radius: 20px;
        background: #69bda8;
        color: #101d1a;
        text-align: center;
        padding: 100px 0;
        margin: 40px auto;
        cursor: pointer;
    }
    .block-red {
        width: 400px;
        border-radius: 20px;
        background: #e06b63;
        color: #4e0702;
        text-align: center;
        padding: 100px 0;
        margin: 40px auto;
        cursor: wait;
    }
</style>