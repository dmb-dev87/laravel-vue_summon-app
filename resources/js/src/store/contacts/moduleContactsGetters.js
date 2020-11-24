export default {
    getItem: state => (contactId) => state.contacts.find((contact) => contact.id == contactId),
  }
  