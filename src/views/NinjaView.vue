<template>
  <h2 style="margin-top: 50px;">
    Ninja React Timer
  </h2>
  <button
    class="large-button"
    :disabled="isPlaying"
    @click="start"
  >
    play
  </button>
  <Block
    v-if="isPlaying"
    :delay="delay"
    @end="endGame"
  />
  <Results
    v-if="showResults"
    :score="score"
  />
  <p v-if="showResults">
    Reaction time: {{ score }}ms
  </p>
</template>

<script>
// @ is an alias to /src
import Block from '@/components/Block.vue'
import Results from '@/components/Results.vue'

export default {
  name: 'HomeView',
  components: {
    Block,
    Results,
  },
  data() {
    return {
      isPlaying: false,
      delay: null,
      score: null,
      showResults: false,
    }
  },
  methods: {
    start () {
      this.delay = 2000 + Math.random() * 5000
      this.isPlaying = true
      this.showResults = false
    },
    endGame (reactionTime) {
      this.score = reactionTime
      this.isPlaying = false
      this.showResults = true
    },
  }
}
</script>
