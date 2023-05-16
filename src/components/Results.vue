<template>
    <div>
        <h2 class="result">{{ scoreMsg }}</h2>
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
<style>
    .result {
        background-color: rgb(255, 255, 164);
        color: rgb(117, 117, 0);
        width: 300px;
        line-height: 150%;
        border-radius: 20px;
        text-align: center;
        margin: 40px auto;
        padding: 20px 10px;
        }
</style>