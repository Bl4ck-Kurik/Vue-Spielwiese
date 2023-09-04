<template>
    <div>
        <input v-model.number="gridSize" type="number" min="1" @change="generateGrid" />
        <button class="large-button" @click="generateGrid" style="margin-top: 30px;">Generate Grid</button>
        <table v-if="grid.length">
            <tr v-for="(row, rowIndex) in grid" :key="rowIndex">
                <td v-for="(song, colIndex) in row" :key="colIndex">
                    <div class="content" ref="contentDiv">
                        {{ song }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            gridSize: 5,
            grid: []
        }
    },
    props: {
        songs: {
            type: Array,
            required: true
        }
    },
    methods: {
        generateGrid() {
            this.grid = [];
            let songsClone = JSON.parse(JSON.stringify(this.songs))
            if (songsClone.includes(undefined)) {
                console.error('songsClone contains undefined values');
            }
            let shuffledSongs = this.shuffleArray(songsClone)
            for (let i = 0; i < this.gridSize; i++) {
                let row = []
                for (var j = 0; j < this.gridSize; j++) {
                    row.push(shuffledSongs.pop())
                }
                this.grid.push(row)
                this.adjustFontSize()
            }
        },
        shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1))
                if (typeof array[i] === 'undefined' || typeof array[j] === 'undefined') {
                    console.error('Undefined element detected:', i, j);
                }
                const temp = array[i];
                array[i] = array[j];
                array[j] = temp;
            }
            return array
        },
        adjustFontSize() {
            this.$nextTick(() => {
                const divs = this.$refs.contentDiv
                divs.forEach(div => {
                    let fontSize = 16
                    div.style.fontSize = `${fontSize}px`
                    while (div.scrollHeight > div.clientHeight && fontSize > 8) {
                        fontSize -= 0.5
                        div.style.fontSize = `${fontSize}px`
                    }
                })
            })
        }
    }
}
</script>
<style scoped>
table {
    border-collapse: collapse;
    margin: auto;
    margin-top: 30px;
}
td {
    width: 120px;
    height: 120px;
    overflow: hidden;
    padding: 0;
}
.content {
    width: 120px;
    height: 120px;
    display: grid;
    place-items: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    padding: 4px;
    border: 1px solid #fff;
    border-radius: 0;
}
tr:first-child td:first-child .content {
    border-radius: 7px 0 0 0;
}
tr:first-child td:last-child .content {
    border-radius: 0 7px 0 0;
}
tr:last-child td:first-child .content {
    border-radius: 0 0 0 7px;
}
tr:last-child td:last-child .content {
    border-radius: 0 0 7px 0;
}
</style>