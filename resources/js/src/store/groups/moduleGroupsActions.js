import axios from '@/axios.js'

axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`

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
  deleteGroup({ commit }, group_id) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/groups/${group_id}`)
        .then((response) => {
          commit('DELETE_GROUP', group_id)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  createGroup ({ commit }, group) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/groups`, {group})
        .then((response) => {
          commit('CREATE_GROUP', Object.assign(group, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateGroup ({ commit }, group) {
    return new Promise((resolve, reject) => {      
      axios.put(`/api/groups/${group.id}`, {group})
        .then((response) => {
          commit('UPDATE_GROUP', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
}
