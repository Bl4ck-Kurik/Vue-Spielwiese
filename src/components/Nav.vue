<template>
    <div class="nav">
        <div class="nav-item" @mouseenter="showSub(1)" @mouseleave="hideSub(1)">
            <div class="nav-link" @click="gotoLink(link1)">    
                <h3>{{ nav1 }}</h3>
            </div>
            <transition name="slide-fade">
            <div class="sub" v-show="sub1">
                <p @click="gotoLink(link1sub1)">{{ nav1sub1 }}</p>
                <p @click="gotoLink(link1sub2)">{{ nav1sub2 }}</p>
            </div>
            </transition>
        </div>
        <div class="nav-item" @mouseenter="showSub(2)" @mouseleave="hideSub(2)">
            <div class="nav-link" @click="gotoLink(link2)">    
                <h3>{{ nav2 }}</h3>
            </div>
            <transition name="slide-fade">
            <div class="sub" v-show="sub2">
                <p @click="gotoLink(link2sub1)">{{ nav2sub1 }}</p>
                <p @click="gotoLink(link2sub2)">{{ nav2sub2 }}</p>
            </div>
            </transition>
        </div>
        <div class="nav-item" @mouseenter="showSub(3)" @mouseleave="hideSub(3)">
            <div class="nav-link" @click="gotoLink(link3)">    
                <h3>{{ nav3 }}</h3>
            </div>
            <transition name="slide-fade">
            <div class="sub" v-show="sub3">
                <p @click="gotoLink(link3sub1)">{{ nav3sub1 }}</p>
                <p @click="gotoLink(link3sub2)">{{ nav3sub2 }}</p>
            </div>
            </transition>
        </div>
        <div class="nav-item" @mouseenter="showSub(4)" @mouseleave="hideSub(4)">
            <div class="nav-link" @click="gotoLink(link4)">    
                <h3>{{ nav4 }}</h3>
            </div>
            <transition name="slide-fade">
            <div class="sub" v-show="sub4">
                <p @click="gotoLink(link4sub1)">{{ nav4sub1 }}</p>
                <p @click="gotoLink(link4sub2)">{{ nav4sub2 }}</p>
            </div>
            </transition>
        </div>
        <div class="nav-item" @mouseenter="showSub(5)" @mouseleave="hideSub(5)">
            <div class="nav-link" @click="gotoLink(link5)">    
                <h3>{{ nav5 }}</h3>
            </div>
            <transition name="slide-fade">
            <div class="sub" v-show="sub5">
                <p @click="gotoLink(link4sub1)">{{ nav5sub1 }}</p>
                <p @click="gotoLink(link4sub2)">{{ nav5sub2 }}</p>
            </div>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                sub1: false,
                sub2: false,
                sub3: false,
                sub4: false,
                sub5: false,
            }
        },
        props: [
            'theme', 
            "nav1", 
            "nav2", 
            "nav3", 
            "nav4", 
            "nav5", 
            "link1", 
            "link2", 
            "link3", 
            "link4", 
            "link5",
            "nav1sub1",
            "nav1sub2",
            "nav2sub1",
            "nav2sub2",
            "nav3sub1",
            "nav3sub2",
            "nav4sub1",
            "nav4sub2",
            "nav5sub1",
            "nav5sub2",
            "link1sub1", 
            "link1sub2", 
            "link2sub1", 
            "link2sub2", 
            "link3sub1", 
            "link3sub2", 
            "link4sub1", 
            "link4sub2", 
            "link5sub1", 
            "link5sub2", 
        ],
        methods: {
            showSub(navItemId) {
                this.sub1 = false;
                this.sub2 = false;
                this.sub3 = false;
                this.sub4 = false;
                this.sub5 = false;

                if (navItemId === 1) {
                    this.sub1 = true;
                } else if (navItemId === 2) {
                    this.sub2 = true;
                } else if (navItemId === 3) {
                    this.sub3 = true;
                } else if (navItemId === 4) {
                    this.sub4 = true;
                } else if (navItemId === 5) {
                    this.sub5 = true;
                }
            },
            hideSub(navItemId) {
                if (navItemId === 1) {
                    this.sub1 = false;
                } else if (navItemId === 2) {
                    this.sub2 = false;
                } else if (navItemId === 3) {
                    this.sub3 = false;
                } else if (navItemId === 4) {
                    this.sub4 = false;
                } else if (navItemId === 5) {
                    this.sub5 = false;
                }
            },
            gotoLink(link) {
                window.location.href = link;
            }
        }
    }
</script>

<style scoped>
@import '../assets/nav.css';
</style>