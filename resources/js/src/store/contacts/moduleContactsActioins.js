import axios from '@/axios.js'

axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`

export default {
  fetchContactsList({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/contacts')
        .then((response) => {
          commit('SET_CONTACTS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  deleteContact ({ commit }, contact_id) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/contacts/${contact_id}`)
        .then((response) => {
          commit('DELETE_CONTACT', contact_id)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateContact ({ commit }, contact) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/contacts/${contact.id}`, {contact})
        .then((response) => {
          commit('UPDATE_CONTACT', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  createContact ({ commit }, contact) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/contacts`, {contact})
        .then((response) => {
          commit('CREATE_CONTACT', Object.assign(contact, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
