<template>
  <h1>{{ title }}</h1>
  <div v-if="showModal">
    <Modal theme="sale" @close="toggleModal">
      <template v-slot:links>
        <a href="#">sign up now</a>
        <a href="#">more info</a>
      </template>
      <h1>V-Bucks Giveaway!</h1>
      <p>Get your Skull Trooper here (swag)!</p>
    </Modal>
  </div>
  <button @click.shift="toggleModal">open modal (shift)</button>

  <div v-if="showModalTwo">
    <Modal theme="sale" @close="toggleModalTwo">
      <template v-slot:links>
        <a href="#">sign up now</a>
        <a href="#">more info</a>
      </template>
      <h1>V-Bucks Giveaway!</h1>
      <p>Get your Skull Trooper here (swag)!</p>
    </Modal>
  </div>
  <button @click.alt="toggleModalTwo">open modal (alt)</button>

  <h2 style="margin-top: 50px;">Ninja React Timer</h2>
  <button @click="start">play</button>
  
  <h2 style="margin-top: 50px;">Standart Nav</h2>
  <p>Anzahl der Tabs und Sub-menü punkte <strong>NICHT</strong> frei wählbar</p>
  
  <Nav 
  nav1="YouTube" 
  nav2="Twitter" 
  nav3="Instagram" 
  nav4="Reddit" 
  nav5="Facebook" 
  link1="https://youtube.com" 
  link2="https://twitter.com" 
  link3="https://instagram.com" 
  link4="https://reddit.com" 
  link5="https://facebook.com"
  nav1sub1="Vue JS 3 Tutorial"
  nav1sub2="sub content 1-2"
  nav2sub1="sub content 2-1"
  nav2sub2="sub content 2-2"
  nav3sub1="sub content 3-1"
  nav3sub2="sub content 3-2"
  nav4sub1="sub content 4-1"
  nav4sub2="sub content 4-2"
  nav5sub1="sub content 5-1"
  nav5sub2="sub content 5-2"
  link1sub1="https://www.youtube.com/watch?v=KM1U6DqZf8M"
  link1sub2="#1sub2"
  link2sub1="#2sub1"
  link2sub2="#2sub2"
  link3sub1="#3sub1"
  link3sub2="#3sub2"
  link4sub1="#4sub1"
  link4sub2="#4sub2"
  link5sub1="#5sub1"
  link5sub2="#5sub2"
  />

  <h2 style="margin-top: 50px;">Flex Nav</h2>
  <p>Anzahl der Tabs und Sub-menü punkte frei wählbar</p>

  <FlexNav :items="navItems" />
  <router-view />

</template>

<script>
import Modal from './components/Modal.vue'
import Nav from './components/Nav.vue'
import FlexNav from './components/FlexNav.vue'

export default {
  name: 'App',
  data () {
    return {
      title: 'My First Vue APP',
      header: 'Sign Up for free V-Bucks',
      text: 'Get the new Skull trooper (swag)!',
      showModal: false,
      showModalTwo: false,
      isPlaying: false,
      delay: null,
      navItems: [
        {
          label: "Tab 1",
          link: "/tab1",
          subItems: [
            {
              label: "Subpunkt 1",
              link: "/subpunkt1",
            },
            {
              label: "Subpunkt 2",
              link: "/subpunkt2",
            },
          ],
        },
        {
          label: "Tab 2",
          link: "/tab2",
          subItems: [
            {
              label: "Subpunkt 3",
              link: "/subpunkt3",
            },
            {
              label: "Subpunkt 4",
              link: "/subpunkt4",
            },
          ],
        },
      ],
    }
  },
  methods: {
    handleClick() {
      console.log(this.$refs.name)
      this.$refs.name.classList.add('active')
      this.$refs.name.focus()
    },
    toggleModal () {
      this.showModal = !this.showModal
    },
    toggleModalTwo () {
      this.showModalTwo = !this.showModalTwo
    },
    start () {
      this.delay = 2000 + Math.random() * 5000
      this.isPlaying = true
      console.log(this.delay)
    }
  },
  components: {
    Modal,
    Nav,
    FlexNav
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>