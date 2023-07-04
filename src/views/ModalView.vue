<template>
  <div v-if="showModal">
    <Modal
      theme="sale"
      @close="toggleModal"
    >
      <template #links>
        <a href="#">sign up now</a>
        <a href="#">more info</a>
      </template>
      <h1>V-Bucks Giveaway!</h1>
      <p>Get your Skull Trooper here (swag)!</p>
    </Modal>
  </div>
  <button @click.shift="toggleModal">
    open modal (shift)
  </button>

  <div v-if="showModalTwo">
    <Modal
      theme="sale"
      @close="toggleModalTwo"
    >
      <template #links>
        <a href="#">sign up now</a>
        <a href="#">more info</a>
      </template>
      <h1>V-Bucks Giveaway!</h1>
      <p>Get your Skull Trooper here (swag)!</p>
    </Modal>
  </div>
  <button @click.alt="toggleModalTwo">
    open modal (alt)
  </button>
</template>
<script>
import Modal from '@/components/Modal.vue'

export default {
  components: {
    Modal,
  },
  data() {
    return {
      header: 'Sign Up for free V-Bucks',
      text: 'Get the new Skull trooper (swag)!',
      showModal: false,
      showModalTwo: false,
    }
  },
  methods: {
    toggleModal () {
      this.showModal = !this.showModal
    },
    toggleModalTwo () {
      this.showModalTwo = !this.showModalTwo
    },
  },
}
</script>