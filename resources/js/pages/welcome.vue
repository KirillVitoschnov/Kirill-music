<template>
  <div class="main-wrapper">
    <v-sidebar/>
    <v-content>
      <music-list-item v-for="music in musicList" :key="music.id" :music="music" @setTrack="updateTrack"
                       @addToPlaylist="addToPlaylistModal"
      />
    </v-content>
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
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'

export default {
  components: {},

  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    selectedTrack: '',
    playListForm: new Form({
      name: ''
    }),
    form: new Form({
      music_id: '',
      playlist_id: ''
    })
  }),
  async mounted () {
    await this.$store.dispatch('music/fetchUserPlayLists')
  },
  methods: {
    async createPlaylist () {
      await this.playListForm.post('/api/playlists')
      await this.$store.dispatch('music/fetchUserPlayLists')
      this.playListForm.name = ''
    },
    async addToPlaylist (playlist) {
      this.form.music_id = this.selectedTrack
      this.form.playlist_id = playlist
      await this.form.post('/api/add-music')
      await this.$store.dispatch('music/fetchUserPlayLists')
      this.$bvModal.hide('add-playlist')
    },
    addToPlaylistModal (track) {
      this.selectedTrack = track
      this.$bvModal.show('add-playlist')
    },
    updateTrack (track) {
      this.$store.commit('music/SET_CURRENT_PLAYLIST', this.musicList)
      this.$store.commit('music/SET_ACTIVE_TRACK', track)
    }
  },

  computed: mapGetters({
    musicList: 'music/getMusicList',
    authenticated: 'auth/check',
    userPlaylists: 'music/getUserPlaylists'
  })
}
</script>
<style lang="scss" scoped>
img {
  width: 50px;
  height: 50px;
  border-radius: 4px;
  margin-right: 20px;
  object-fit: cover;
}

.info {
  width: 200px;
  flex: 1;
}

h3 {
  margin-top: 0;
  margin-bottom: 10px;
}

p {
  margin: 0;
  font-size: 14px;
}
</style>
