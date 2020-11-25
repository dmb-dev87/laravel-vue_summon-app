export default {
    SET_GROUPS (state, groups) {      
      state.groups = groups
    },
    DELETE_GROUP (state, group_id) {
      const ItemIndex = state.groups.findIndex((p) => p.id === group_id)
      state.groups.splice(ItemIndex, 1)
    },
    CREATE_GROUP (state, group) {
      state.groups.unshift(group)
    },
    UPDATE_GROUP (state, group) {
      const ItemIndex = state.groups.findIndex((p) => p.id === group.id)
      Object.assign(state.groups[ItemIndex], group)
    },
  }
  