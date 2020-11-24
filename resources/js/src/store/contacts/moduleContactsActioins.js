import axios from '@/axios.js'

export default {
  fetchContactsList({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/contacts/1')
        .then((response) => {
          commit('SET_CONTACTS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
}
