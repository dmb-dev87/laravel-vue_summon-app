import state from './moduleLocationsState.js'
import mutations from './moduleLocationsMutatioins.js'
import actions from './moduleLocationsActions.js'
import getters from './moduleLocationsGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}