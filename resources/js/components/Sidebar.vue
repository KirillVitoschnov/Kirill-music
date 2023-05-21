<template>
  <nav class="sidebar">
    <div class="url-items-wrapper">
      <router-link :to="{ name: 'main' }">
        <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M13.8318 15.6H8.51817V10.2H5.48176V15.6H0.168091V4.37625L6.99997 0.400024L13.8318 4.34913V15.6Z"
          />
        </svg>
        <span>Главная</span>
      </router-link>


      <router-link v-if="user" :to="{ name: 'library' }">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 40 40" fill="none">
          <path
            d="M23.7394 2.07173L39 36.344L35.412 37.9283L20.1515 3.65605L23.7394 2.07173ZM1 37.5089V2.28145H4.9141V37.5089H1ZM10.7854 37.5089V2.28145H14.6996V37.5089H10.7855H10.7854Z"
          />
        </svg>
        <span>
          Библиотека
        </span>
      </router-link>
    </div>
  </nav>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
  name: 'VSidebar',
  computed: mapGetters({
    user: 'auth/user'
  })
}
</script>
