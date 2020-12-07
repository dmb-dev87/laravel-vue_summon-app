import Vue from 'vue'
import App from './App.vue'

// Vuesax Component Framework
import Vuesax from 'vuesax'

Vue.use(Vuesax)

// axios
import axios from './axios.js'
Vue.prototype.$http = axios

// API Calls
import './http/requests'

// Theme Configurations
import '../themeConfig.js'

// Auth0 Plugin
import AuthPlugin from './plugins/auth'
Vue.use(AuthPlugin)

// ACL
import acl from './acl/acl'

// vue session
import VueSession from 'vue-session'
Vue.use(VueSession)

// Globally Registered Components
import './globalComponents.js'

// Vue Router
import router from './router'

// Vuex Store
import store from './store/store'

// i18n
import i18n from './i18n/i18n'

// Vuexy Admin Filters
import './filters/filters'

// Clipboard
import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)

// Tour
import VueTour from 'vue-tour'
Vue.use(VueTour)
require('vue-tour/dist/vue-tour.css')

// VeeValidate
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate)

// Vuejs - Vue wrapper for hammerjs
import { VueHammer } from 'vue2-hammer'
Vue.use(VueHammer)

import GoogleAuth from '@/authServices/google_oAuth.js'
const gauthOption = {
  clientId: '104984059628-rseoem0e054uup9f7bt6m2hrf9cm4lf1.apps.googleusercontent.com',
  scope: 'https://www.googleapis.com/auth/calendar.events https://www.googleapis.com/auth/contacts',
  prompt: 'select_account'
}
Vue.use(GoogleAuth, gauthOption)

// PrismJS
import 'prismjs'
import 'prismjs/themes/prism-tomorrow.css'

// Feather font icon
require('@assets/css/iconfont.css')

// Vue select css
// Note: In latest version you have to add it separately
import 'vue-select/dist/vue-select.css';

Vue.config.productionTip = false

new Vue({
  router,
  store,
  i18n,
  acl,
  render: h => h(App)
}).$mount('#app')
