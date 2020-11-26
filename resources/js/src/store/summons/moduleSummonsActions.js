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
          commit('CREATE_SUMMON', Object.assign(summon, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

  ////////////////////////////////////////////////////////////////////////
  updateAboutChat ({ commit, rootState }, value) {
    commit('UPDATE_ABOUT_CHAT', {
      rootState,
      value
    })
  },
  updateStatusChat ({ commit, rootState }, value) {
    commit('UPDATE_STATUS_CHAT', {
      rootState,
      value
    })
  },

  // API CALLS
  sendChatMessage ({ getters, commit, dispatch }, payload) {
    return new Promise((resolve, reject) => {
      axios.post('/api/apps/chat/msg', {payload})
        .then((response) => {
          payload.chatData = getters.chatDataOfUser(payload.id)
          if (!payload.chatData) { dispatch('fetchChatContacts') }
          commit('SEND_CHAT_MESSAGE', payload)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

  // Get contacts from server. Also change in store
  fetchContacts ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/apps/chat/contacts', {params: {q: ''}})
        .then((response) => {
          commit('UPDATE_CONTACTS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

  // Get chat-contacts from server. Also change in store
  fetchChatContacts ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/apps/chat/chat-contacts', {params: {q: ''}})
        .then((response) => {
          commit('UPDATE_CHAT_CONTACTS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

  // Get chats from server. Also change in store
  fetchChats ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/apps/chat/chats')
        .then((response) => {
          commit('UPDATE_CHATS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

  markSeenAllMessages ({ getters, commit }, id) {

    return new Promise((resolve, reject) => {
      axios.post('/api/apps/chat/mark-all-seen', {id})
        .then((response) => {
          commit('MARK_SEEN_ALL_MESSAGES', {
            id,
            chatData: getters.chatDataOfUser(id)
          })
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

  toggleIsPinned ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      axios.post('/api/apps/chat/set-pinned/', {contactId: payload.id,
        value: payload.value})
        .then((response) => {
          commit('TOGGLE_IS_PINNED', payload)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}