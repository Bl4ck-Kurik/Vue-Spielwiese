<template>
  <h1>{{ title }}</h1>
  <FlexNav :items="navItems" />
  <router-view/>
</template>

<script>

import FlexNav from './components/FlexNav.vue'

export default {
  name: 'App',
  data () {
    return {
      title: 'My First Vue APP',
      navItems: [
        {
          label: "Notes",
          link: "/notes",
        },
        {
          label: "Ninja React Timer",
          link: "/ninja",
        },
        {
          label: "Sign Up!",
          link: "/signup",
        },
        {
          label: "Todo List",
          link: "/todo",
        },
        {
          label: "Example Tab",
          link: "#",
          subItems: [
            {
              label: "sub 1",
              link: "#",
            },
            {
              label: "sub 2",
              link: "#",
            },
          ],
        },
      ],
    }
  },
  methods: {
    
  },
  components: {
    FlexNav,
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #fff;
  background-color: #000;
  margin: 60px 0 120px;
}
</style>