export default {
    SET_CONTACTS (state, contacts) {      
      state.contacts = contacts
    },
    DELETE_CONTACT (state, contact_id) {
      const ItemIndex = state.contacts.findIndex((p) => p.id === contact_id)
      state.contacts.splice(ItemIndex, 1)
    },
    CREATE_CONTACT (state, contact) {
      state.contacts.unshift(contact)
    },
    UPDATE_CONTACT (state, contact) {
      const contactId = state.contacts.findIndex((p) => p.id === contact.id)
      Object.assign(state.contacts[contactId], contact)
    },
  }
  