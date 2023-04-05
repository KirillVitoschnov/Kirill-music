<template>
  <div class="main-wrapper">
    <b-modal id="add-playlist" hide-footer hide-header>
      <div>
        <div>
          <h2 class="title-add-music">
            Добавить в плейлист
          </h2>
          <div class="form-container">
            <input v-model="playListForm.name" type="text" class="input" placeholder="Введите название плейлиста">
            <button class="btn-modal" @click="createPlaylist">
              Добавить
            </button>
          </div>
          <div class="cards-playlist-wrapper">
            <div v-for="playlist in userPlaylists" :key="playlist.id" @click="addToPlaylist(playlist)">
              <div class="card">
                <img v-if="playlist.musics[0]" :src="playlist.musics[0].logo_url" :alt="playlist.musics[0].title">
                <img v-else class="music-logo" src="/images/music-logo.png">
                <div class="info">
                  <h3>{{ playlist.name }}</h3>
                  <p>Создан: {{ playlist.created_at |date }}</p>
                  <p>Колличество песен: {{ playlist.musics_count }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
    <v-sidebar/>
    <v-content>
      <div class="library-title">
        <h1>{{ playlistName }}</h1>
      </div>
      <music-list-item v-show="loaded" v-for="music in playList" :key="music.id" :music="music" @setTrack="updateTrack"
                       @addToPlaylist="addToPlaylistModal"
      />
    </v-content>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'

export default {

  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    selectedTrack: '',
    playListForm: new Form({
      name: ''
    }),
    form: new Form({
      music_id: '',
      playlist_id: ''
    }),
    title: window.config.appName,
    loaded: false
  }),
  async created () {
    this.$store.commit('SET_CURRENT_PLAYLIST', [])
    await this.$store.dispatch('music/fetchUserPlayLists')
    await this.$store.dispatch('music/fetchPlaylistById', this.$route.params.id)
    this.loaded = true
  },
  methods: {
    addToPlaylistModal (track) {
      this.selectedTrack = track
      this.$bvModal.show('add-playlist')
    },
    updateTrack (track) {
      this.$store.commit('music/SET_CURRENT_PLAYLIST', this.playList)
      this.$store.commit('music/SET_ACTIVE_TRACK', track)
    }

  },

  computed: {
    ...mapGetters({
      userPlayLists: 'music/getUserPlaylists',
      playList: 'music/getCurrentPlaylist',
      musicList: 'music/getMusicList',
      authenticated: 'auth/check'
    }),
    playlistName () {
      return this.userPlayLists.length ? this.userPlayLists.find((obj) => obj.id == this.$route.params.id).name : ''
    }
  }
}
</script>
