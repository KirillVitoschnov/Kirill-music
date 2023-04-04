<template>
  <router-link :to="{ name: 'playlist', params: { id: item.id } }" class="library-card">
    <img v-if="item.musics[0]" class="music-logo" :src="`${item.musics[0].logo_url}`">
    <img v-else class="music-logo" src="/images/music-logo.png">
    <span>{{ item.name }}</span>
  </router-link>
</template>
<script>
export default {
  name: 'PlaylistCard',
  props: ['item']
}
</script>
