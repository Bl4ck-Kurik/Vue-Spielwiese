<template lang="">
  <div>
    <ul>
      <li
        v-for="(item, index) in todoItems"
        :key="index"
      >
        <input
          v-model="item.completed"
          type="checkbox"
        >
        <span :class="{ 'completed': item.completed }">{{ item.text }}</span>
        <button @click="deleteItem(index)">
          Delete
        </button>
      </li>
    </ul>
    <div class="newItem">
      <input
        v-model="newItemText"
        class="newItemText"
        type="text"
      >
      <button
        class="addItem"
        @click="addItem"
      >
        Add
      </button>
    </div>
  </div>
</template>
<script>
export default {
    data() {
        return {
            todoItems: [],
            newItemText: '',
        }
    },
    methods: {
        addItem() {
            if (this.newItemText) {
                this.todoItems.push({
                    text: this.newItemText,
                    completed: false
                }),
                this.newItemText = ''
            }
        },
        deleteItem(index) {
            this.todoItems.splice(index, 1)
        }
    },
}
</script>
<style>
    .newItem {
        display: flex;
        align-items: center;
        flex-direction: column;
    }
    .newItemText {
        max-width: 250px;
        border-radius: 5px;
    }
    .addItem {
        margin: 10px;
    }
</style>