import axios from '@/axios.js'

export default {
  fetchGroupsList({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/groups')
        .then((response) => {
          commit('SET_GROUPS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
}
