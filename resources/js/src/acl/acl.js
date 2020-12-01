import Vue from 'vue'
import { AclInstaller, AclCreate, AclRule } from 'vue-acl'
import router from '@/router'

Vue.use(AclInstaller)

let initialRole = 'User'

const userInfo = JSON.parse(localStorage.getItem('userInfo'))
if (userInfo && userInfo.role_name) initialRole = userInfo.role_name

export default new AclCreate({
  initial  : initialRole,
  notfound : '/not-authorized',
  router,
  acceptLocalRules : true,
  globalRules: {
    admin  : new AclRule('Admin').generate(),
    user : new AclRule('User').or('Admin').generate()
  }
})
