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
        <v-select class="mt-2" v-model="sel_contacts" multiple :closeOnSelect="false" :options="contactOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />

        <vs-list-header title="Group"></vs-list-header>
        <v-select class="mt-2" v-model="sel_groups" multiple :closeOnSelect="false" :options="groupOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />

        <vs-list-header title="Location"></vs-list-header>
        <v-select v-model="sel_location" :options="locationOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />

        <vs-list-header title="Due Date"></vs-list-header>
        <flat-pickr :config="configdateTimePicker" v-model="due_datetime" placeholder="Date Time" class="w-full"/>

        <vs-list-header title="Type Message"></vs-list-header>
        <div class="chat__input flex p-0 bg-white">
          <vs-progress class="flex-1" v-if="!messageType" indeterminate color="primary" style="margin-top: 17px;"></vs-progress>
          <vs-input class="flex-1" v-if="messageType" placeholder="Type Your Message" v-model="typedMessage" @keyup.enter="sendMsg" />                    
          <vs-button class="ml-2" radius color="primary" type="filled" icon-pack="feather" icon="icon-voicemail" @click="changemethod"></vs-button>
          <vs-button class="bg-primary-gradient ml-2" type="filled" icon-pack="feather" icon="icon-navigation" @click="sendMsg"></vs-button>
        </div>
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
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import moduleSummons from '@/store/summons/moduleSummons.js'

export default {
  components: {
    VuePerfectScrollbar,
    SummonLog,
    SummonNavbar,
    vSelect,
    flatPickr
  },
  data () {
    return {
      sel_contacts: [],
      sel_groups: [],
      sel_location: 0,
      due_datetime: null,
      configdateTimePicker: {
        enableTime: true,
        dateFormat: 'Y-m-d h:i K'
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
    sendMsg () {
      if (!this.typedMessage) 
        return

      const summonObj = {
        'message': this.typedMessage,
        'due_date': this.due_datetime,
        'sel_groups': this.sel_groups,
        'sel_contacts': this.sel_contacts,
        'sel_location': this.sel_location,
      }

      this.$store.dispatch('summons/createSummon', summonObj).catch(err => { console.error(err) })
      this.$store.dispatch('summons/sendChatMessage', summonObj).catch(err => { console.error(err) })
      
      this.typedMessage = ''

      const scroll_el = this.$refs.chatLogPS.$el || this.$refs.chatLogPS
      scroll_el.scrollTop = this.$refs.chatLog.scrollHeight
    },
    changemethod () { 
      this.messageType = !  this.messageType
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
</style>
