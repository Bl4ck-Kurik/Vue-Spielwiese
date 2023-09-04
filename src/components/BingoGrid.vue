<template>
    <div>
        <input v-model.number="gridSize" type="number" min="1" @change="generateGrid" />
        <button @click="generateGrid">Generate Grid</button>
        <pre>{{ songs }}</pre>
        <table v-if="grid.length">
            <tr v-for="(row, rowIndex) in grid" :key="rowIndex">
                <td v-for="(song, colIndex) in row" :key="colIndex">{{ song }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            gridSize: 5, // default size
            grid: []
        }
    },
    props: {
        songs: {
            required: true
        }
    },
    methods: {
        generateGrid() {
            this.grid = [];
            let songsClone = JSON.parse(JSON.stringify(this.songs))
            console.log('1')
            let shuffledSongs = this.shuffleArray(songsClone)
            console.log("Grid Size:", this.gridSize)
            for (let i = 0; i < this.gridSize; i++) {
                console.log('2')
                let row = []
                for (let randomIndex = 0; randomIndex < this.gridSize; randomIndex++) {
                    console.log('3')
                    row.push(shuffledSongs.pop())
                }
                this.grid.push(row)
                console.log('4')
            }
        },
        shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const randomIndex = Math.floor(Math.random() * (i + 1))
                [array[i], array[randomIndex]] = [array[randomIndex], array[i]]
            }
            return array
        }
    }
}
</script>
