<template>
  <div class="main-wrapper">
    <v-sidebar></v-sidebar>
    <v-content>
      <music-list-item @setTrack="updateTrack" v-for="music in musicList" :music="music" :key="music.id"></music-list-item>
    </v-content>
  </div>

</template>


<script>
import {mapGetters} from 'vuex'

export default {
  components: {},

  layout: 'basic',

  metaInfo() {
    return {title: this.$t('home')}
  },

  data: () => ({
    title: window.config.appName
  }),

  methods: {
    updateTrack(track) {
      this.SET_MUSIC_LIST(this.musicList);
    }
  },

  computed: mapGetters({
    musicList: 'music/getMusicList',
    authenticated: 'auth/check'
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
