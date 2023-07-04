<template>
  <div>
    <h2 style="margin-top: 30px;">
      Take Notes
    </h2>
    <button
      class="newNote"
      @click="showNotes"
    >
      New Note
    </button>
    <div class="search">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search"
      >
      <select v-model="sortOrder">
        <option value="asc">
          Ascending
        </option>
        <option value="desc">
          Descending
        </option>
      </select>
    </div>
    <div
      v-if="newNote"
      class="newNoteInput"
    >
      <input
        v-model="newNoteTitle"
        class="title"
        type="text"
        placeholder="Title"
      >
      <textarea
        v-model="newNoteText"
        cols="30"
        rows="10"
        class="content"
        placeholder="Content"
      />
      <div class="editButtons">
        <button
          class="addNote"
          @click="addNote"
        >
          Add Note
        </button>
        <button
          class="closeNote"
          @click="showNotes"
        >
          Close
        </button>
      </div>
    </div>
    <div class="notes">
      <div
        v-for="(item, index) in searchResult"
        :key="index"
      >
        <div
          v-if="editNote === item"
          class="notesContent"
        >
          <div>
            <input
              v-model="editedTitle"
              type="text"
            >
            <textarea v-model="editedText" />
          </div>
          <div class="noteButtons">
            <div>
              <button
                class="saveNote"
                @click="saveNote"
              >
                Save
              </button>
              <button
                class="closeNote"
                @click="editNote = null"
              >
                Close
              </button>
            </div>    
            <button
              class="deleteNote"
              @click="deleteNote"
            >
              Delete
            </button>
          </div>
        </div>
        <div
          v-else
          class="notesContent"
          @click="editNoteIndex(index)"
        >
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
            searchQuery: '',
            sortOrder: 'asc',
            editNote: null,
            editedTitle: '',
            editedText: '',
            newNote: false,
            newNoteTitle: '',
            newNoteText: '',
            noteItems: [],
        }
    },
    computed: {
        searchResult() {
            let sortedNotes = [...this.noteItems]
            if (this.searchQuery) {
                this.editNote = null
                sortedNotes = sortedNotes.filter(item =>
                    item.title.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
            }
            if (this.sortOrder === 'asc') {
                this.editNote = null
                sortedNotes.sort((a, b) => a.title.localeCompare(b.title))
            } else if (this.sortOrder === 'desc') {
                this.editNote = null
                sortedNotes.sort((a, b) => b.title.localeCompare(a.title))
            }
            return sortedNotes
        }
    },
    created() {
        if (localStorage.getItem('noteItems')) {
            this.noteItems = JSON.parse(localStorage.getItem('noteItems'));
        }
    },
    methods: {
        showNotes () {
            this.newNote = !this.newNote
            this.editNote = null
        },
        addNote () {
            this.editNote = null
            if (this.newNoteTitle && this.newNoteText) {
                if (this.editNote !== null) {
                    this.noteItems[this.editNote].title = this.newNoteTitle
                    this.noteItems[this.editNote].text = this.newNoteText
                } else {
                    this.noteItems.push({
                        title: this.newNoteTitle,
                        text: this.newNoteText
                })
                localStorage.setItem('noteItems', JSON.stringify(this.noteItems))
                }
                this.newNote = false
                this.newNoteTitle = ''
                this.newNoteText = ''
                this.editNote = null
            }
        },
        editNoteIndex(index) {
            this.editNote = this.searchResult[index]
            let originalIndex = this.noteItems.indexOf(this.editNote)
            this.editedTitle = this.noteItems[originalIndex].title
            this.editedText = this.noteItems[originalIndex].text
        },
        saveNote() {
            if(this.editNote !== null) {
                let originalIndex = this.noteItems.indexOf(this.editNote)
                this.noteItems[originalIndex].title = this.editedTitle
                this.noteItems[originalIndex].text = this.editedText
                localStorage.setItem('noteItems', JSON.stringify(this.noteItems))
            }
            this.editNote = null
            this.editedTitle = ''
            this.editedText = ''
        },
        deleteNote() {
            if(this.editNote !== null) {
                let originalIndex = this.noteItems.indexOf(this.editNote);
                this.noteItems.splice(originalIndex, 1);
                localStorage.setItem('noteItems', JSON.stringify(this.noteItems));
            }
            this.editNote = null;
            this.editedTitle = '';
            this.editedText = '';
        },
    },
}
</script>
<style>
    .title {
        margin: 10px 0 10px;
    }
    .newNote, .addNote, .saveNote, .closeNote, .deleteNote, .closeNote {
        font-size: 17px;
        padding: 10px;
    }
    .newNote {
        margin-bottom: 10px;
        width: 700px;
    }
    .newNoteInput {
        margin-bottom: 20px;
        width: 700px;
        margin: auto;
    }
    .addNote {
        margin-top: 20px;
    }
    .saveNote, .closeNote, .deleteNote {
        margin-top: 10px;
    }
    .saveNote, .closeNote {
        align-items: start;
        justify-content: lefts;
    }
    .deleteNote {
        color: #5e0101;
        background-color: #ff5555;
    }
    .saveNote, .addNote {
        color: rgb(1, 54, 1);
        background-color: rgb(125, 223, 125);
    }
    .notes {
        margin-top: 20px;
    }
    .notes h3, .notes p, .notes input, .notes textarea {
        background-color: rgba(47, 79, 79, 0.288);
        border: 1px solid darkslategray;
        border-radius: 7px;
        margin: 0;
        text-align: left;
        padding: 10px;
        word-wrap: break-word;
    }
    .notes input, .notes textarea {
        width: 670px;
    }
    .notes p, .notes h3 {
        width: 648px;
    }
    .notes h3, .notes input {
        margin-bottom: 5px;
    }
    .notes li, .notesContent {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        flex-wrap: wrap;
        width: 700px;
        padding: 15px 0 15px;
        margin: 10px auto 10px auto;
        background-color: rgba(47, 79, 79, 0.15);
        border-radius: 7px;
    }
    .noteButtons {
        display: flex;
        justify-content: space-between;
        width: 670px;
    }
    .search {
        display: flex;
        margin: 0 auto 10px auto;
        width: 700px;
    }
    .search input {
        margin-right: 10px;
    }
    .search select {
        width: 20%;
    }
</style>