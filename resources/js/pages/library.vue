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
        </div>
      </div>
    </b-modal>
    <v-sidebar/>
    <v-content>
      <div class="library-title">
        <h1>Плейлисты</h1>
        <button class="library-add" @click="$bvModal.show('add-playlist')">
          <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
            <g fill="currentColor">
              <path
                d="M17.9 11.9a.9.9 0 1 0-1.8 0v3.2h-3.2a.9.9 0 1 0 0 1.8h3.2v3.2a.9.9 0 0 0 1.8 0v-3.2h3.2a.9.9 0 0 0 0-1.8h-3.2zm-14-5h14.2a.9.9 0 1 0 0-1.8H3.9a.9.9 0 1 0 0 1.8zm0 3.2a.9.9 0 1 0 0 1.8h9.2a.9.9 0 0 0 0-1.8zm0 5a.9.9 0 1 0 0 1.8h5.2a.9.9 0 0 0 0-1.8z"
              />
            </g>
          </svg>
        </button>
      </div>
      <div class="library-wrapper">
        <playlist-card v-for="item in playList" :key="item.id" :item="item"/>
      </div>
    </v-content>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import PlaylistCard from '../components/playlistCard'
import Form from 'vform'

export default {
  components: { PlaylistCard },

  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    playListForm: new Form({
      name: ''
    })
  }),
  async mounted () {
    await this.$store.dispatch('music/fetchUserPlayLists')
  },
  methods: {
    async createPlaylist () {
      await this.playListForm.post('/api/playlists')
      await this.$store.dispatch('music/fetchUserPlayLists')
      this.$bvModal.hide('add-playlist')
      this.playList.name = ''
    }
  },

  computed: mapGetters({
    playList: 'music/getUserPlaylists',
    authenticated: 'auth/check'
  })
}
</script>
