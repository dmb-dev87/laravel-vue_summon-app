import state from './moduleContactsState.js'
import mutations from './moduleContactsMutations.js'
import actions from './moduleContactsActioins.js'
import getters from './moduleContactsGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}