import axios from '@/axios.js'

axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`

export default {
  createEvent ({ commit }, event) {
    return new Promise((resolve, reject) => {
      axios.post('/api/events', {event})
        .then((response) => {
          commit('CREATE_EVENT', Object.assign(event, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchEvents ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/events')
        .then((response) => {
          commit('SET_EVENTS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchEventLabels ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/apps/calendar/labels')
        .then((response) => {
          commit('SET_LABELS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateEvent ({ commit }, event) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/events/${event.id}`, {event})
        .then((response) => {
          commit('UPDATE_EVENT', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  deleteEvent ({ commit }, eventId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/event/${eventId}`)
        .then((response) => {
          commit('REMOVE_EVENT', eventId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  eventDragged ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/events/dragged/${payload.event.id}`, {payload})
        .then((response) => {
          commit('UPDATE_EVENT', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
