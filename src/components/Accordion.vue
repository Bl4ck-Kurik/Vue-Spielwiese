<template>
    <div @click="showAccordion" class="accordion">
        <div class="head" v-if="!show">
            <slot name="head"></slot>
            <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M5 3l3.057-3 11.943 12-11.943 12-3.057-3 9-9z" fill="white"/>
            </svg>
        </div>
        <div class="wrapper" v-if="show">
            <div class="title">
                <slot name="title"></slot>
            </div>
            <div class="content">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            show: false,    
        }
    },
    methods: {
        showAccordion() {
            this.show = !this.show
        }
    },
}
</script>
<style>
    .arrow {
        width: 17px;
        display: block;
        margin-left: auto;
    }
    .accordion {
        background-color: darkslategray;
        min-height: 20px;
        width: 700px;
        padding: 12px 12px;
        margin: 50px auto;
        border-radius: 7px;
    }
    .wrapper {
        padding: 0;
        margin-top: -10px;
    }
    .head {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .title {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 7px;
        padding: 2px;
    }
    .content {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 7px;
        padding: 1px 10px;
    }
</style>