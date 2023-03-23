import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
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
Vue.filter('date', function (value) {
  const date = new Date(value)
  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric'
  }
  return date.toLocaleDateString('ru', options)
})
Vue.filter('seconds-to-minutes', function (value) {
  if (!value) return ''
  let seconds = value
  const hours = Math.floor(seconds / 3600)
  const minutes = Math.floor((seconds % 3600) / 60)
  seconds = Math.round(seconds % 60)
  let time = ''
  if (hours > 0) {
    time += (hours < 10 ? '0' + hours : hours) + ':'
  }
  time += (minutes < 10 ? '0' + minutes : minutes) + ':' + (seconds < 10 ? '0' + seconds : seconds)
  return time
})

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
