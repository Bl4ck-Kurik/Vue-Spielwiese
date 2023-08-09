<template>
    <div>
        <pre>{{ movies }}</pre>
        <FormKit 
            type="form"
            @submit="submitHandler"
            v-model="movies"
        >
            <h2>Movie Watchlist</h2>
            <FormKit 
                type="text"
                name="movie"
                label="Movie"
                validation="length:3"
            />
            <FormKit
                type="checkbox"
                name="watched"
                label="Already Watched"
            />
        </FormKit>
    </div>
</template>
<script>
export default {
    data() {
        return {
            movies: {},
        }
    },
    methods: {
        submitHandler() {
            this.movies = {
                "movie": "test",
                "watched": false
            }
            console.log(this.movies)
        }
    },
}
</script>
<style>
    
</style>