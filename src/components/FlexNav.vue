<template>
    <div class="nav">
      <div v-for="(item, index) in items" :key="index" class="nav-item" @mouseenter="showSub(index)" @mouseleave="hideSub(index)">
        <div class="nav-link" @click="gotoLink(item.link)">
          <h3>{{ item.label }}</h3>
        </div>
        <transition name="slide-fade">
          <div class="sub" v-show="item.showSub">
            <p v-for="(subItem, subIndex) in item.subItems" :key="subIndex" @click="gotoLink(subItem.link)">{{ subItem.label }}</p>
          </div>
        </transition>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      items: {
        type: Array,
        required: true,
      },
    },
    methods: {
      showSub(index) {
        this.items[index].showSub = true;
      },
      hideSub(index) {
        this.items[index].showSub = false;
      },
      gotoLink(link) {
        window.location.href = link;
      },
    },
  };
  </script>

<style scoped>
@import '../assets/nav.css';
</style>