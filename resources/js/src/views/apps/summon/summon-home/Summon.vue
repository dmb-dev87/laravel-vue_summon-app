<template>
  <div id="chat-app" class="border border-solid d-theme-border-grey-light rounded relative overflow-hidden">
    <vs-sidebar class="items-no-padding" parent="#chat-app" :click-not-close="clickNotClose" :hidden-background="clickNotClose" v-model="isChatSidebarActive" id="chat-list-sidebar">
      <div class="chat__profile-search flex p-4">
        <vs-input icon-pack="feather" class="w-full" hidden />
        <feather-icon class="md:inline-flex lg:hidden ml-5 cursor-pointer" icon="XIcon" @click="toggleChatSidebar(false)" />
      </div>
      <vs-divider class="d-theme-border-grey-light m-0" />
      <component :is="scrollbarTag" class="chat-scroll-area" style="padding: 10px;" :settings="settings" :key="$vs.rtl">
        <vs-list-header title="Contact"></vs-list-header>
        <v-select class="mt-2" name="item-contacts" v-model="sel_contacts" multiple :closeOnSelect="false" :options="contactOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger text-sm" v-show="errors.has('item-contacts') && errors.has('item-groups')">{{ errors.first('item-contacts') }}</span>

        <vs-list-header title="Group"></vs-list-header>
        <v-select class="mt-2" name="item-groups" v-model="sel_groups" multiple :closeOnSelect="false" :options="groupOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger text-sm" v-show="errors.has('item-contacts') && errors.has('item-groups')">{{ errors.first('item-groups') }}</span>

        <vs-list-header title="Location"></vs-list-header>
        <v-select class="mt-2" name="item-location" v-model="sel_location" :options="locationOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-location')">{{ errors.first('item-location') }}</span>

        <vs-list-header title="Due Date"></vs-list-header>
        <div class="flex p-0 bg-white">
          <datetime v-model="due_date" class="mr-3" format="dd/MM/yyyy" value-zone="Asia/Bahrain" zone="Asia/Bahrain"></datetime>
          <datetime type="time" v-model="due_time" use12-hour format="HH:mm a" value-zone="Asia/Bahrain" zone="Asia/Bahrain"></datetime>
        </div>
        <span class="text-danger text-sm" v-show="invalid_date">You can't select the past date.</span>

        <vs-list-header title="Type Message"></vs-list-header>
        <div class="chat__input flex p-0 bg-white">
          <vs-progress class="flex-1" v-if="!messageType" indeterminate color="primary" style="margin-top: 17px;"></vs-progress>
          <vs-input class="flex-1" name="item-message" v-if="messageType" placeholder="Type Your Message" v-model="typedMessage" @keyup.enter="createSummon" v-validate="'required'" />
          <vs-button class="ml-2" radius color="primary" type="filled" icon-pack="feather" icon="icon-voicemail" @click="changemethod"></vs-button>
          <vs-button class="bg-primary-gradient ml-2" type="filled" icon-pack="feather" icon="icon-navigation" @click="createSummon"></vs-button>
        </div>
        <span class="text-danger text-sm" v-show="errors.has('item-message') && messageType">{{ errors.first('item-message') }}</span>
      </component>
    </vs-sidebar>

    <!-- RIGHT COLUMN -->
    <div class="chat__bg no-scroll-content chat-content-area border border-solid d-theme-border-grey-light border-t-0 border-r-0 border-b-0" :class="{'sidebar-spacer--wide': clickNotClose, 'flex items-center justify-center': activeChatUser === null}">
      <div class="chat__navbar">
        <summon-navbar :isSidebarCollapsed="!clickNotClose" @openContactsSidebar="toggleChatSidebar(true)" />
      </div>
      <component :is="scrollbarTag" class="chat-content-scroll-area border border-solid d-theme-border-grey-light" :settings="settings" ref="chatLogPS" :key="$vs.rtl">
        <div class="chat__log" ref="chatLog">
          <summon-log />
        </div>
      </component>
    </div>
  </div>
</template>

<script>
import SummonLog from './SummonLog.vue'
import SummonNavbar from './SummonNavbar'
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import vSelect from 'vue-select'
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import moduleSummons from '@/store/summons/moduleSummons.js'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

export default {
  components: {
    VuePerfectScrollbar,
    SummonLog,
    SummonNavbar,
    vSelect,
    flatPickr,
    datetime: Datetime
  },
  data () {
    return {
      sel_contacts: [],
      sel_groups: [],
      sel_location: null,
      start_date: null,
      end_date: null,
      configdateTimePicker: {
        enableTime: true,
        dateFormat: 'd/m/Y h:i K'
      },
      messageType: true,
      typedMessage: '',
      isChatSidebarActive: true,
      clickNotClose: true,
      activeChatUser: true,
      settings             : {
        maxScrollbarLength : 60,
        wheelSpeed         : 0.70
      },
      invalid_date: false,
      due_date: '',
      due_time: '',
      summon_id: 0,
    }
  },
  watch: {
    windowWidth () {
      this.setSidebarWidth()
    }
  },
  computed: {
    locationOptions () {
      return this.$store.state.summons.locationOptions
    },
    groupOptions () {
      return this.$store.state.summons.groupOptions
    },
    contactOptions () {
      return this.$store.state.summons.contactOptions
    },
    scrollbarTag () {
      return this.$store.getters.scrollbarTag
    },
    windowWidth () {
      return this.$store.state.windowWidth
    }
  },
  methods: {
    createSummon () {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.end_date = this.due_date.split('T')[0] + 'T' + this.due_time.split('T')[1]
          this.start_date = new Date()

          let endDate = new Date(this.end_date)

          if (this.start_date > endDate)
          {
            this.invalid_date = true
            return
          }

          this.invalid_date = false

          const summonObj = {
            'message': this.typedMessage,
            'start_date': this.start_date,
            'end_date': this.end_date,
            'sel_groups': this.sel_groups,
            'sel_contacts': this.sel_contacts,
            'sel_location': this.sel_location,
          }

          this.$store.dispatch('summons/createSummon', summonObj)
            .then(response => {
              console.log("+++++++++++++++++++++", response)
              this.sendMessage(response.data.id)
            })
            .catch(err => { 
              console.error(err) 
            })
          
          // this.initValues()
          const scroll_el = this.$refs.chatLogPS.$el || this.$refs.chatLogPS
          scroll_el.scrollTop = this.$refs.chatLog.scrollHeight
        }
      })
    },
    sendMessage (summon_id) {
      console.log("++++++++++++++++++++++++++++++++++++++++", summon_id)
      this.$vs.loading();
      this.$store.dispatch('summons/sendMessage', summon_id)
        .then((response) => {
          this.$vs.notify({
            title: 'Success',
            text: response.data.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'success'
          })
          this.$vs.loading.close()
        })
        .catch(err => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Error',
            text: err.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })
    },
    initValues () {
      this.typedMessage = ''
      this.sel_contacts = []
      this.sel_groups = []
      this.sel_location = null
      this.start_date = null
      this.end_date = null
    },
    changemethod () {
      this.messageType = !  this.messageType

      // let result = this.$validator.validateAll()

      // if (result != false)
      //   return

      console.log("+++++++++++++++++++++", this.messageType)
      if (!this.messageType)
      {
        this.end_date = this.due_date.split('T')[0] + 'T' + this.due_time.split('T')[1]
        this.start_date = new Date()

        let endDate = new Date(this.end_date)

        if (this.start_date > endDate)
        {
          this.invalid_date = true
          return
        }

        this.invalid_date = false

        const summonObj = {
          'message': this.typedMessage,
          'start_date': this.start_date,
          'end_date': this.end_date,
          'sel_groups': this.sel_groups,
          'sel_contacts': this.sel_contacts,
          'sel_location': this.sel_location,
        }

        this.$store.dispatch('summons/recordVoicemail', summonObj)
          .then(response => {
            console.log("+++++++++++++++", response)
            // this.sendMessage(response.data.id)
          })
          .catch(err => { 
            console.error(err) 
          })
        
        // this.initValues()
        const scroll_el = this.$refs.chatLogPS.$el || this.$refs.chatLogPS
        scroll_el.scrollTop = this.$refs.chatLog.scrollHeight
      }
    },
    setSidebarWidth () {
      if (this.windowWidth < 1200) {
        this.isChatSidebarActive = this.clickNotClose = false
      } else {
        this.isChatSidebarActive = this.clickNotClose = true
      }
    },
    toggleChatSidebar (value = false) {
      if (!value && this.clickNotClose) return
      this.isChatSidebarActive = value
    }
  },  
  created () {
    this.due_date = new Date().toISOString()
    this.due_time = new Date().toISOString()
    if (!moduleSummons.isRegistered) {
      this.$store.registerModule('summons', moduleSummons)
      moduleSummons.isRegistered = true
    }
    this.$store.dispatch('summons/fetchSummonsList')
    this.$store.dispatch('summons/fetchLocationOptions')
    this.$store.dispatch('summons/fetchGroupOptions')
    this.$store.dispatch('summons/fetchContactOptions')
    this.setSidebarWidth()
  },
  beforeDestroy () {
    this.$store.unregisterModule('summons')
    moduleSummons.isRegistered = false
  },
  mounted () {
  }
}
</script>

<style lang="scss">
@import "@sass/vuexy/apps/chat.scss";

.vdatetime-input {
  width: 100%;
  color: inherit;
  font-size: 14px;
  padding: 0.7rem;
  border-radius: 5px;
  border: 1px solid rgba(0, 0, 0, 0.2);
}

</style>
