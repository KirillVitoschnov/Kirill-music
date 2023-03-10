<template>
  <div class="library-card">
    <img v-if="item.musics[0]" class="music-logo" :src="`${item.musics[0].logo_url}`">
    {{ item.name }}
  </div>
</template>
<script>
export default {
  name: 'playlistCard',
  props: ['item'],
}
</script>
