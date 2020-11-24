import state from './moduleGroupsState.js'
import mutations from './moduleGroupsMutations.js'
import actions from './moduleGroupsActions.js'
import getters from './moduleGroupsGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}