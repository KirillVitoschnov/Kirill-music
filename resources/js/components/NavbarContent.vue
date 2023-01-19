<template>
  <nav class="wrapper-profile-header">

    <button class="button-header">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
        <path opacity="0.7"
              d="M12.1728 15.6L3.27344 8.00002L12.1728 0.400024L12.7266 1.04756L4.58555 8.00002L12.7266 14.9525"
              fill="white"/>
      </svg>
    </button>
    <button class="button-header next">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
        <path opacity="0.7"
              d="M12.1728 15.6L3.27344 8.00002L12.1728 0.400024L12.7266 1.04756L4.58555 8.00002L12.7266 14.9525"
              fill="white"/>
      </svg>
    </button>

    <div class="user-signin" v-if="!user">

      <router-link :to="{ name: 'login' }" class="header-auth">
        Авторизация
      </router-link>
      <router-link :to="{ name: 'register' }" class="header-auth">
        Регистрация
      </router-link>

    </div>
    <svg @click="$bvModal.show('upload-music')" style="margin: auto 10px auto auto; cursor: pointer"
         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
         id="mdi-download" width="24" height="24" viewBox="0 0 24 24">
      <path fill="white" d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z"/>
    </svg>
    <router-link :to="{ name: 'profile' }" v-if="user" v class="user-profile-wrapper">
      <img class="user-image" :src="user.photo_url" alt="">
      <span>{{ user.name }}</span>
    </router-link>

    <b-modal id="upload-music" title="BootstrapVue">
      <form method="post" enctype="multipart/form-data" action="/api/music/upload">
        <input type="text" name="title">
        <input type="text" name="artist">
        <input name="music" type="file">
        <button type="submit">Загрузить</button>
      </form>
    </b-modal>
  </nav>
</template>
<script>
import {mapGetters} from "vuex";

export default {
  name: 'VNavbarContent',
  computed: mapGetters({
    user: 'auth/user'
  }),
}
</script>
