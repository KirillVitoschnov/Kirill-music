<template>
  <div @click="onTrackClick" class="music-item">
    <img class="music-logo" :src="`${music.logo_url}`">
    <div class="music-data">
      <div>{{ music.title }}</div>
      <div>{{ music.artist }}</div>
    </div>
    <span class="music-action"> <b-dropdown id="dropdown-1" text="Действие">
      <b-dropdown-item @click="download('/storage/'+music.path, music.title+' '+music.artist)">Скачать</b-dropdown-item>
      <b-dropdown-item v-if="user" @click="addToPlaylist">Добавить в плейлист</b-dropdown-item>
    </b-dropdown>
    </span>

    <span class="music-time">{{ music.seconds | seconds-to-minutes }}</span>
  </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
  name: 'MusicListItem',
  props: ['music'],
  created() {

  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    addToPlaylist() {
      this.$emit('addToPlaylist', this.music.id);
    },
    download(url, Filename) {
      fetch(url)
        .then(response => response.blob())
        .then(blob => {
          const a = document.createElement('a')
          const url = URL.createObjectURL(blob)
          a.href = url
          a.download = Filename
          document.body.appendChild(a)
          a.click()
          setTimeout(() => {
            document.body.removeChild(a)
            window.URL.revokeObjectURL(url)
          }, 0)
        })
    },
    onTrackClick() {
      this.$emit('setTrack', this.music.id)
    }
  }

}
</script>
