<template>
  <nav class="wrapper-profile-header">
    <div v-if="!user" class="user-signin">
      <router-link :to="{ name: 'login' }" class="header-auth">
        Авторизация
      </router-link>
      <router-link :to="{ name: 'register' }" class="header-auth">
        Регистрация
      </router-link>
    </div>
    <svg v-if="user" id="mdi-download" style="cursor: pointer"
         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
         width="24" height="24" viewBox="0 0 24 24" @click="$bvModal.show('upload-music')"
    >
      <path fill="white" d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z"/>
    </svg>
    <router-link v-if="user" :to="{ name: 'profile' }" v class="user-profile-wrapper">
      <img class="user-image" :src="user.photo_url" alt="">
      <span>{{ user.name }}</span>
    </router-link>

    <b-modal id="upload-music" hide-header hide-footer>
      <form @submit.prevent="upload">
        <label for="music-file">Выберите файл:</label>
        <b-form-file
          v-model="uploadTrack.music"
          placeholder="Choose a file or drop it here..."
          drop-placeholder="Drop file here..."
        />
        <label for="playlist">Выберите плейлист:</label>
        <select v-model="uploadTrack.playlist_id" id="playlist" name="playlist" class="form-input form-input-select">
          <option v-for="playlist in userPlaylists" :key="playlist.id" :value="playlist.id">
            {{ playlist.name }}
          </option>
        </select>
        <input type="submit" value="Загрузить" class="form-submit">
      </form>
      <!--      <form method="post" enctype="multipart/form-data" action="/api/music/upload">-->
      <!--        <input type="text" name="title">-->
      <!--        <input type="text" name="artist">-->
      <!--        <input name="music" type="file">-->
      <!--        <button type="submit">-->
      <!--          Загрузить-->
      <!--        </button>-->
      <!--      </form>-->
    </b-modal>
  </nav>
</template>
<script>
import { mapGetters } from 'vuex'
import Form from 'vform'

export default {
  name: 'VNavbarContent',
  data: () => ({
    uploadTrack: new Form({
      music: null,
      playlist_id: ''
    })
  }),
  methods: {
    async upload () {
      await this.uploadTrack.post('/api/music/upload')
      this.$bvModal.hide('add-playlist')
    }
  },
  computed: mapGetters({
    user: 'auth/user',
    userPlaylists: 'music/getUserPlaylists'
  })
}
</script>
