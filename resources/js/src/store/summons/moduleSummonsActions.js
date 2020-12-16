import axios from '@/axios.js'

axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`

export default {
  fetchSummonsList({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/summons')
        .then((response) => {
          commit('SET_SUMMONS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchLocationOptions({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/summons/location_options`)
        .then((response) => {
          commit('SET_LOCATION_OPTIONS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchGroupOptions({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/summons/group_options`)
        .then((response) => {
          commit('SET_GROUP_OPTIONS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchContactOptions({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/summons/contact_options`)
        .then((response) => {
          commit('SET_CONTACT_OPTIONS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  createSummon ({ commit }, summon) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/summons`, {summon})
        .then((response) => {
          if (response.data) {
            commit('CREATE_SUMMON', response.data)
          }
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  recordVoicemail({ commit }, summon) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/summons/voice/record`, {summon})
        .then((response) => {
          if (response.data) {
            commit('CREATE_SUMMON', response.data)
          }
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  fetchHistories({ commit }, summon_id) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/histories/${summon_id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  sendMessage ({ commit }, summon_id) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/summons/send/${summon_id}`)
        .then((response) => {          
          if (response.data) {
            commit('SENT_SUMMON', response.data)
          }
          resolve(response)
        })
        .catch((error) =>{
          reject(error)
        })
    })
  },  
}