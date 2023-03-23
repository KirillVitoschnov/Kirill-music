<template>
  <div class="main-wrapper">
    <v-sidebar/>
    <v-content>
      <music-list-item v-for="music in musicList" :key="music.id" :music="music" @setTrack="updateTrack"
                       @addToPlaylist="addToPlaylist"
      />
    </v-content>
    <b-modal id="add-playlist" title="BootstrapVue">
      <form method="post" enctype="multipart/form-data" action="/api/add-music">
        <div>
          <div v-for="playlist in userPlaylists" :key="playlist.id" @click="selectedPlayList=playlist.id">
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
          <input name="playlist_id" type="hidden" v-model="selectedPlayList">
          <input name="music_id" type="hidden" v-model="selectedTrack">
        </div>
        <button type="submit">
          Загрузить
        </button>
      </form>
    </b-modal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  components: {},

  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    selectedTrack: '',
    selectedPlayList: ''
  }),
  async mounted () {
    await this.$store.dispatch('music/fetchUserPlayLists')
  },
  methods: {
    addToPlaylist (track) {
      this.selectedTrack = track
      this.selectedPlayList = ''
      this.$bvModal.show('add-playlist')
    },
    updateTrack (track) {
      this.SET_MUSIC_LIST(this.musicList)
    }
  },

  computed: mapGetters({
    musicList: 'music/getMusicList',
    authenticated: 'auth/check',
    userPlaylists: 'music/getUserPlaylists'
  })
}
</script>
<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
<style scoped>
.card {
  justify-content: space-between;
  flex-direction: initial;
  display: flex;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-bottom: 20px;
}

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
