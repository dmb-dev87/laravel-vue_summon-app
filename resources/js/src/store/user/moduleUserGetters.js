export default {
    getItem: state => (userId) => state.users.find((user) => user.id == userId),
  }
  