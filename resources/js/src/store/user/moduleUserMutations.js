export default {
    SET_USERS (state, users) {
      state.users = users
    },
    UPDATE_USER (state, user) {
      const userId = state.users.findIndex((p) => p.id === user.id)
      Object.assign(state.users[userId], user)
    },
    DELETE_USER (state, userId) {
      const ItemIndex = state.users.findIndex((p) => p.id === userId)
      state.users.splice(ItemIndex, 1)
    }
  }
  