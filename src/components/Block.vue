<template>
    <div class="block" v-if="showBlock && !gameOver" @click="stopTimer">click me</div>
    <div class="block-red" v-else-if="!showBlock && !gameOver" @click="endGameEarly">click when green!</div>
    <div class="block-yellow" v-if="gameOver" @click="resetGame">You clicked too soon, click to restart!</div>
</template>
<script>
export default {
    props: ['delay'],
    data() {
        return {
            showBlock: false,
            timer: null,
            reactionTime: 0,
            gameCount: 0,
            gameOver: false,
            gameStart: null,
        }
    },
    mounted() {
        this.startGame();
    },
    methods: {
        startTimer () {
            this.timer = setInterval(() => {
                this.reactionTime += 10
            }, 10)
        },
        stopTimer () {
            if (this.gameOver) {
                return
            }
            clearInterval(this.timer)
            this.$emit('end', this.reactionTime)
            this.reactionTime = 0
            this.showBlock = false
            this.gameCount++
            if (this.gameCount < 2 && !this.gameOver) {
                this.gameStart = setTimeout(() => this.startGame(), 1000)
            }
        },
        startGame() {
            this.gameStart = setTimeout(() => {
                this.showBlock = true
                this.startTimer()
            },  this.delay)
        },
        endGameEarly() {
            this.gameOver = true
            clearInterval(this.timer)
            clearTimeout(this.gameStart)
        },
        resetGame() {
            this.gameOver = false
            this.gameCount = 0
            this.showBlock = false
            clearTimeout(this.gameStart)
            clearInterval(this.timer)
            this.startGame()
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
    .block-yellow {
        width: 400px;
        border-radius: 20px;
        background: rgb(255, 255, 164);
        color: rgb(117, 117, 0);
        text-align: center;
        padding: 100px 0;
        margin: 40px auto;
        cursor: pointer;
    }
</style>