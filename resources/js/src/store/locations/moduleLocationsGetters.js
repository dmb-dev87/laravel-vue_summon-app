export default {
    getItem: state => (locationId) => state.locations.find((location) => location.id == locationId),
  }
  