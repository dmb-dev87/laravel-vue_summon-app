import state from './moduleSummonsState.js'
import mutations from './moduleSummonsMutations.js'
import actions from './moduleSummonsActions.js'
import getters from './moduleSummonsGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}