import axios from '@/axios.js'

axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`

export default {
  fetchUserList({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/users')
        .then((response) => {
          commit('SET_USERS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateUser ({ commit }, user) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/users/${user.id}`, {user})
        .then((response) => {
          commit('UPDATE_USER', response.data)
          resolve(response)
          location.reload()
        })
        .catch((error) => { reject(error) })
    })
  },
  deleteUser ({ commit }, userId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/users/${userId}`)
        .then((response) => {
          commit('DELETE_USER', userId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
