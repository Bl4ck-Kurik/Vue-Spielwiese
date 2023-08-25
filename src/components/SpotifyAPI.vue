<template>
    <div>
        <input class="urlInput" v-model="url" placeholder="Enter Spotify Playlist Link" />
        <button class="fetchData large-button" @click="fetchPlaylistData">Fetch Playlist Data</button>
        <div class="songList" v-if="playlistData">
            <p v-for="(playlistTrackList, index) in playlistTrackList" :key="index" v-if="playlistData">{{ index + 1 }}: {{ playlistTrackList }}</p>
        </div>
    </div>
  </template>
  
<script>
import axios from 'axios'

export default {
    name: 'SpotifyComponent',
    data() {
        return {
            trackData: null,
            trackId: '',
            playlistData: null,
            playlistTrackList: null,
            url: '',
        }
    },
    methods: {
        async fetchAccessToken() {
            try {
                const clientID = '097ea1134cdf4f45908f66126a3bd447'
                const clientSecret = '1c61722a8a1d48ff87170a6e3fdd5b3f'
                const basicAuth = btoa(`${clientID}:${clientSecret}`)
                const response = await axios({
                    method: 'post',
                    url: 'https://accounts.spotify.com/api/token',
                    headers: {
                        Authorization: `Basic ${basicAuth}`,
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    data: new URLSearchParams({
                        grant_type: 'client_credentials',
                    }), 
                })
                return response.data.access_token;
            } catch (error) {
                console.error('Error fetching access token:', error)
            }
        },
        async fetchPlaylistData() {
            const accessToken = await this.fetchAccessToken();
            const regex = /https:\/\/open\.spotify\.com\/playlist\/([a-zA-Z0-9]+)/
            const match = this.url.match(regex)
            const playlistId = match ? match[1] : null
            if (!accessToken || !playlistId) return
            let offset = 0
            const limit = 100
            let allTracks = []

            try {
                while (true) {
                const response = await axios({
                    method: 'get',
                    url: `https://api.spotify.com/v1/playlists/${playlistId}/tracks?limit=${limit}&offset=${offset}`,
                    headers: {
                    Authorization: `Bearer ${accessToken}`,
                    },
                })
                allTracks = allTracks.concat(response.data.items)
                if (response.data.items.length < limit) {
                    break
                }
                offset += limit
                }
                this.playlistData = {
                    ...this.playlistData,
                    tracks: {
                        items: allTracks,
                    },
                }
                console.log(this.playlistData)
                this.playlistTrackList = allTracks.map(item => {
                const artistNames = item.track.artists.map(artist => artist.name).join(', ')
                return `${item.track.name} by ${artistNames}`
                })
            } catch (error) {
                console.error('Error fetching playlist data:', error)
            }
        }
    },
}
</script>
<style>
.songList {
    text-align: left;
    max-width: 700px;
    margin: 50px auto auto auto;
}
.urlInput {
    max-width: 700px;
    margin: auto;
}
.fetchData {
    margin-top: 10px;
}
</style>