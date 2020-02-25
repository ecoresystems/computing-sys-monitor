import Vue from 'vue'
import VueRouter from "vue-router";


import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './App.vue'
import axios from 'axios'

import VPN from "./components/VPN.vue"

Vue.use(ElementUI)
Vue.use(axios)
Vue.prototype.$axios = axios
Vue.use(VueRouter);

const router = new VueRouter({
  routes:[

    {
      path:'/vpn',
      component:VPN
    }
  ]
})

new Vue({
  el: '#app',
  router,
  render: h => h(App)
})