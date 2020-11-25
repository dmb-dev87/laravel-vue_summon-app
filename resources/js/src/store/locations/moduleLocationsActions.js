import axios from '@/axios.js'

axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`

export default {
  fetchLocationsList({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/locations')
        .then((response) => {
          commit('SET_LOCATIONS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  createLocation ({ commit }, location_item) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/locations`, {location_item})
        .then((response) => {
          commit('CREATE_LOCATION', Object.assign(location_item, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateLocation ({ commit }, location_item) {
    return new Promise((resolve, reject) => {      
      axios.put(`/api/locations/${location_item.id}`, {location_item})
        .then((response) => {
          commit('UPDATE_LOCATION', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  deleteLocation ({ commit }, location_id) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/locations/${location_id}`)
        .then((response) => {
          commit('DELETE_LOCATION', location_id)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
