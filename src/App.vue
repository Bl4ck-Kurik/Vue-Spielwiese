<template>
  <h1>{{ title }}</h1>
  <FlexNav :items="navItems" />
  <!-- <Api/> -->
  <div id="router-view">
    <router-view/>
  </div>
  <!-- <Accordion>
    <template v-slot:head>
      <h2 style="color: white;">cooles accordion und so ja</h2>
    </template>
    <template v-slot:title>
      <h1>Header</h1>
    </template>
    <template v-slot:content>
      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
    </template>
  </Accordion> -->
</template>

<script>
import FlexNav from '@/components/FlexNav.vue'
import Accordion from '@/components/Accordion.vue'
import Api from '@/components/Api.vue'

export default {
  name: 'App',
  data () {
    return {
      title: 'My First Vue APP',
      navItems: [
        {
          label: "Home",
          link: "/",
        },
        {
          label: "Notes",
          link: "/notes",
        },
        {
          label: "File Upload",
          link: "/files",
        },
        {
          label: "Bingo",
          link: "/bingo",
        },
        {
          label: "FormKit Playground",
          link: "/form-kit",
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
    Accordion,
    Api,
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