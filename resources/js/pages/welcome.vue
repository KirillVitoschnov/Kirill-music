<template>
  <div class="main-wrapper">
    <v-sidebar></v-sidebar>
    <v-content></v-content>
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

  computed: mapGetters({
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
