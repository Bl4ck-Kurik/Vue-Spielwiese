<template>
  <div>
    <h2
      class="result"
      v-html="scoreMsg"
    />
  </div>
</template>
<script>
export default {
    props: ['score'],
    computed: {
        scoreMsg() {
        if (this.score == 0) {
            return "<h1>too soon</h1>"
        } else if (this.score <= 300) {
            return `your reaction time time is ${this.score}ms<br><h1>Ninja Fingers</h1>`
        } else if (this.score <= 400) {
            return `your reaction time time is ${this.score}ms<br><h1>Rapid Reflexes</h1>`
        } else {
            return `your reaction time time is ${this.score}ms<br><h1>Snail pace</h1>`
        }
        }
    }
}
</script>
<style>
    .result {
        background-color: rgb(255, 255, 164);
        color: rgb(117, 117, 0);
        width: 400px;
        line-height: 150%;
        border-radius: 20px;
        text-align: center;
        margin: 40px auto;
        padding: 20px 10px;
        }
    .result h1 {
        color: rgb(117, 117, 0);
        line-height: 120%;
        margin: 5px 0 5px;
    }
</style>