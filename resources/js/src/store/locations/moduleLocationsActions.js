import axios from '@/axios.js'

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
}
