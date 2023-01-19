import Vue from 'vue'
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.config.productionTip = false

Vue.filter('seconds-to-minutes', function (value) {
  if (!value) return ''
  let seconds = value
  let hours = Math.floor(seconds / 3600);
  let minutes = Math.floor((seconds % 3600) / 60);
  seconds = Math.round(seconds % 60);
  let time = "";
  if (hours > 0) {
    time += (hours < 10 ? "0" + hours : hours) + ":";
  }
  time += (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);
  return time;


})

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
