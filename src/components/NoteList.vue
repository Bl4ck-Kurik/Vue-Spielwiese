<template lang="">
    <div>
        <h2 style="margin-top: 30px;">Take Notes</h2>
        <button class="newNote" @click="showNotes">New Note</button>
        <div v-if="newNote" class="newNote">
            <input class="title" type="text" placeholder="Title" v-model="newNoteTitle">
            <textarea name="" id="" cols="30" rows="10" class="content" placeholder="Content" v-model="newNoteText"></textarea>
            <button class="addNote" @click="addNote">Add Note</button>
        </div>
        <div class="notes">
            <div v-for="(item, index) in noteItems" :key="index">
                <div v-if="editNote === index" class="notesContent">
                    <input type="text" v-model="item.title">
                    <textarea v-model="item.text"></textarea>
                    <button @click="saveNote" class="saveNote">Save</button>
                </div>
                <div v-else @click="editNote = index" class="notesContent">
                    <h3>{{ item.title }}</h3>
                    <p>{{ item.text }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            editNote: null,
            newNote: false,
            newNoteTitle: '',
            newNoteText: '',
            noteItems: [],
        }
    },
    methods: {
        showNotes () {
            this.newNote = true
        },
        addNote () {
            if (this.newNoteTitle && this.newNoteText) {
                if (this.editNote !== null) {
                    this.noteItems[this.editNote].title = this.newNoteTitle;
                    this.noteItems[this.editNote].text = this.newNoteText;
                } else {
                    this.noteItems.push({
                        title: this.newNoteTitle,
                        text: this.newNoteText
                });
                }
                this.newNote = false;
                this.newNoteTitle = '';
                this.newNoteText = '';
                this.editNote = null;
            }
        },
        saveNote() {
            this.editNote = null
        },
    },
}
</script>
<style>
    .title {
        margin: 10px 0 10px;
    }
    .newNote, .addNote, .saveNote {
        font-size: 17px;
        padding: 10px;
    }
    .newNote {
        margin-bottom: 20px;
    }
    .addNote {
        margin-top: 20px;
    }
    .saveNote {
        margin-top: 10px;
    }
    .notes h3, .notes p, .notes input, .notes textarea {
        background-color: rgba(47, 79, 79, 0.288);
        border: 1px solid darkslategray;
        border-radius: 7px;
        margin: 0;
        text-align: left;
        width: 400px;
        padding: 10px;
        word-wrap: break-word;
    }
    .notes h3, .notes input {
        margin-bottom: 5px;
    }
    .notes li, .notesContent {
        display: flex;
        align-items: center;
        flex-direction: column;
        flex-wrap: wrap;
        width: 450px;
        padding: 15px 0 15px;
        margin: 10px auto 10px auto;
        background-color: rgba(47, 79, 79, 0.15);
        border-radius: 7px;
    }
</style>