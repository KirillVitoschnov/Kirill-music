<template>
  <div class="main-wrapper">
    <v-sidebar/>
    <v-content>
      <div class="library-title">
        <h1>{{ playlistName }}</h1>
      </div>
      <music-list-item v-show="loaded" v-for="music in playList" :key="music.id" :music="music"/>
    </v-content>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    loaded: false
  }),
  async created () {
    this.$store.commit('SET_CURRENT_PLAYLIST', [])
    await this.$store.dispatch('music/fetchUserPlayLists')
    await this.$store.dispatch('music/fetchPlaylistById', this.$route.params.id)
    this.loaded = true
  },
  methods: {},

  computed: {
    ...mapGetters({
      userPlayLists: 'music/getUserPlaylists',
      playList: 'music/getCurrentPlaylist'
    }),
    playlistName () {
      return this.userPlayLists.length ? this.userPlayLists.find((obj) => obj.id == this.$route.params.id).name : ''
    }
  }
}
</script>
