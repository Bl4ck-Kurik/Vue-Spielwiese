<template>
    <div>
    <input v-model="trackId" placeholder="Enter Spotify Track ID" />
    <button @click="fetchTrackData">Fetch Track Data</button>
    <pre v-if="trackData">{{ trackData }}</pre>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'SpotifyComponent',
    data() {
    return {
        trackData: null,
        trackId: '',  // Added this for user input
    };
    },
    methods: {
    async fetchAccessToken() {
        try {
            const clientID = '097ea1134cdf4f45908f66126a3bd447';
            const clientSecret = '1c61722a8a1d48ff87170a6e3fdd5b3f';
            const basicAuth = Buffer.from(`${clientID}:${clientSecret}`).toString('base64');

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
            });

            return response.data.access_token;
    } catch (error) {
        console.error('Error fetching access token:', error);
    }
    },
    async fetchTrackData() {
        const accessToken = await this.fetchAccessToken();

        if (!accessToken || !this.trackId) return;

        try {
        const response = await axios({
            method: 'get',
            url: `https://api.spotify.com/v1/tracks/${this.trackId}`,  // Modified this line
            headers: {
            Authorization: `Bearer ${accessToken}`,
            },
        });

        this.trackData = response.data;
        } catch (error) {
        console.error('Error fetching track data:', error);
        }
    },
    },
};
</script>
