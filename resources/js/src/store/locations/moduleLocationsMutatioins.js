export default {
    SET_LOCATIONS (state, locations) {      
      state.locations = locations
    },
    CREATE_LOCATION (state, item) {
      state.locations.unshift(item)
    },
    UPDATE_LOCATION (state, item) {
      const locationId = state.locations.findIndex((p) => p.id === item.id)
      Object.assign(state.locations[locationId], item)
    },
    DELETE_LOCATION (state, location_id) {
      const ItemIndex = state.locations.findIndex((p) => p.id === location_id)
      state.locations.splice(ItemIndex, 1)
    }
  }
  