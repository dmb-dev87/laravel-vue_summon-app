export default {
    SET_SUMMONS (state, summons) {
        state.summons = summons
    },
    SET_LOCATION_OPTIONS (state, locations) {
        state.locationOptions = locations
    },
    SET_GROUP_OPTIONS (state, groups) {
        state.groupOptions = groups
    },
    SET_CONTACT_OPTIONS (state, contacts) {
        state.contactOptions = contacts
    },
    CREATE_SUMMON (state, summon) {
        console.log('++++++++++++++++++++', summon)
        state.summons.push(summon)
    },
    SENT_SUMMON (state, item) {
        const summonId = state.summons.findIndex((p) => p.id == item.id)
        state.summons[summonId].is_sent = item.sent
    }
  }
