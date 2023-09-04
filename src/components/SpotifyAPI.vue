<template>
    <div>
        <div v-if="!playlistTrackList">
            <input class="urlInput" v-model="url" placeholder="Enter Spotify Playlist Link" />
            <button class="fetchData large-button" @click="fetchPlaylistData">Fetch Playlist Data</button>
            <div class="songList" v-if="playlistData">
                <p v-for="(playlistTrackList, index) in playlistTrackList" :key="index" v-if="playlistData">{{ index + 1 }}: {{ playlistTrackList }}</p>
            </div>
        </div>
        <BingoGrid :songs="playlistTrackList" v-if="playlistTrackList"/>
    </div>
</template>
  
<script>
import axios from 'axios'
import BingoGrid from '@/components/BingoGrid.vue'

export default {
    name: 'SpotifyComponent',
    components: {
        BingoGrid
    },
    data() {
        return {
            trackData: null,
            trackId: '',
            playlistData: null,
            playlistTrackList: '',
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
                let moreTracksAvailable = true;

                while (moreTracksAvailable) {
                    const response = await axios({
                        method: 'get',
                        url: `https://api.spotify.com/v1/playlists/${playlistId}/tracks?limit=${limit}&offset=${offset}`,
                        headers: {
                            Authorization: `Bearer ${accessToken}`,
                        },
                    });

                    // Append the fetched tracks to the allTracks array
                    allTracks = allTracks.concat(response.data.items);

                    // Check if there are more tracks to fetch
                    if (response.data.items.length < limit) {
                        moreTracksAvailable = false;
                    } else {
                        offset += limit;

                        // Optional: Add a delay to avoid hitting rate limits
                        await new Promise(resolve => setTimeout(resolve, 1000)); // 1 second delay
                    }
                }

                this.playlistData = {
                    ...this.playlistData,
                    tracks: {
                        items: allTracks,
                    },
                };

                console.log(this.playlistData);

                let preTrackList = allTracks.map(item => {
                    const artistNames = item.track.artists.map(artist => artist.name).join(', ');
                    return `${item.track.name} by ${artistNames}`;
                });

                this.playlistTrackList = JSON.parse(JSON.stringify(preTrackList))

            } catch (error) {
                console.error('Error fetching playlist data:', error);
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