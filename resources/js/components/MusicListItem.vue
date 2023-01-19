<template>
  <div class="music-item">
    <img class="music-logo" :src="`${music.logo_url}`">
    <div class="music-data">
      <div>{{ music.title }}</div>
      <div>{{ music.artist }}</div>
    </div>
    <span class="music-action">Действие</span>
    <span class="music-time">{{ music.seconds | seconds-to-minutes }}</span>
  </div>
</template>
<script>
export default {
  name: 'MusicListItem',
  props: ['music'],
  created() {

  }
}
</script>
