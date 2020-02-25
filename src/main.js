import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './App.vue'
import VPN from './VPN.vue'
import axios from 'axios'

Vue.use(ElementUI)
Vue.use(axios)
Vue.prototype.$axios = axios

new Vue({
  el: '#app',
  render: h => h(App)
})
new Vue({
  el: '#vpn',
  render: g => g(VPN)
})
