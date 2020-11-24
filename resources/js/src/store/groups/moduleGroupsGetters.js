export default {
    getItem: state => (groupId) => state.groups.find((group) => group.id == groupId),
  }
  