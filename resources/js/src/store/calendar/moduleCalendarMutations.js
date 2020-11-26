export default {
  CREATE_EVENT (state, event) {
    state.events.push(event)
  },
  SET_EVENTS (state, events) {
    state.events = events
  },
  UPDATE_EVENT (state, event) {
    const eventIndex = state.events.findIndex((e) => e.id === event.id)
    Object.assign(state.events[eventIndex], event)
  },
  REMOVE_EVENT (state, eventId) {
    const eventIndex = state.events.findIndex((e) => e.id === eventId)
    state.events.splice(eventIndex, 1)
  }
}
