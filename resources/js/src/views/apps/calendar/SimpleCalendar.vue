<template>
  <div id="simple-calendar-app">
    <div class="vx-card no-scroll-content">
      <calendar-view
        ref="calendar"
        :displayPeriodUom="calendarView"
        :show-date="showDate"
        :events="events"
        enableDragDrop
        :eventTop="windowWidth <= 400 ? '2rem' : '3rem'"
        eventBorderHeight="0px"
        eventContentHeight="1.65rem"
        class="theme-default"
        @click-date="openAddNewEvent"
        @click-event="openEditEvent"
        @drop-on-date="eventDragged">

        <div slot="header" class="mb-4">

          <div class="vx-row no-gutter">

            <!-- Month Name -->
            <div class="vx-col w-1/3 items-center sm:flex hidden">
              <!-- Add new event button -->
              <vs-button icon-pack="feather" icon="icon-plus" @click="openAddNewEvent(new Date())">Add</vs-button>
            </div>

            <!-- Current Month -->
            <div class="vx-col sm:w-1/3 w-full sm:my-0 my-3 flex sm:justify-end justify-center order-last">
              <div class="flex items-center">
                <feather-icon
                  :icon="$vs.rtl ? 'ChevronRightIcon' : 'ChevronLeftIcon'"
                  @click="updateMonth(-1)"
                  svgClasses="w-5 h-5 m-1"
                  class="cursor-pointer bg-primary text-white rounded-full" />

                <span class="mx-3 text-xl font-medium whitespace-no-wrap">{{ showDate | month }}</span>

                <feather-icon
                  :icon="$vs.rtl ? 'ChevronLeftIcon' : 'ChevronRightIcon'"
                  @click="updateMonth(1)"
                  svgClasses="w-5 h-5 m-1"
                  class="cursor-pointer bg-primary text-white rounded-full" />
              </div>
            </div>

            <div class="vx-col sm:w-1/3 w-full flex justify-center">
              <template v-for="(view, index) in calendarViewTypes">
                <vs-button
                  v-if="calendarView === view.val"
                  :key="String(view.val) + 'filled'"
                  type="filled"
                  class="p-3 md:px-8 md:py-3"
                  :class="{'border-l-0 rounded-l-none': index, 'rounded-r-none': calendarViewTypes.length !== index+1}"
                  @click="calendarView = view.val"
                  >{{ view.label }}</vs-button>
                <vs-button
                  v-else
                  :key="String(view.val) + 'border'"
                  type="border"
                  class="p-3 md:px-8 md:py-3"
                  :class="{'border-l-0 rounded-l-none': index, 'rounded-r-none': calendarViewTypes.length !== index+1}"
                  @click="calendarView = view.val"
                  >{{ view.label }}</vs-button>
              </template>

            </div>
          </div>
        </div>
      </calendar-view>
    </div>

    <!-- ADD EVENT -->
    <vs-prompt
      class="calendar-event-dialog"
      :title="isAddOrEdit ? 'Add New Summon' : 'Edit Summon'"
      :accept-text= "isAddOrEdit ? 'Add New Summon' : 'Edit Summon'"
      @accept="addEvent"
      :cancel-text= "isAddOrEdit ? 'Cancel' : 'Remove Summon'"
      @cancel="cancelEvent"
      :is-valid=true
      :active.sync="activePromptAddEvent">

        <vs-input name="item-message" v-validate="'required'" class="w-full" label-placeholder="Summon Message" v-model="title"></vs-input>
        <span class="text-danger text-sm" v-show="errors.has('item-message')">{{ errors.first('item-message') }}</span>
        <flat-pickr class="mt-4" :config="configdateTimePicker" v-model="startDate" placeholder="Date Time" v-validate="'required'" name="item-date" />
        <span class="text-danger text-sm" v-show="errors.has('item-date') || invalid_date">
          <template v-if="errors.has('item-date')">
            {{ errors.first('item-date') }}
          </template>
          <template v-else>
            You can't select the past date.
          </template>
        </span>

        <p class="mt-4">Contact</p>
        <v-select class="mt-2" v-model="sel_contacts" multiple :closeOnSelect="false" :options="contactOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" name="item-contacts" />
        <span class="text-danger text-sm" v-show="errors.has('item-contacts') && errors.has('item-groups')">{{ errors.first('item-contacts') }}</span>

        <p class="mt-4">Group</p>
        <v-select class="mt-2" v-model="sel_groups" multiple :closeOnSelect="false" :options="groupOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" name="item-groups" />
        <span class="text-danger text-sm" v-show="errors.has('item-contacts') && errors.has('item-groups')">{{ errors.first('item-groups') }}</span>

        <p class="mt-4">Location</p>
        <v-select class="mt-2" v-model="sel_location" :options="locationOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'"  name="item-location" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-location')">{{ errors.first('item-location') }}</span>
    </vs-prompt>
  </div>
</template>

<script>
import { CalendarView, CalendarViewHeader } from 'vue-simple-calendar'
import moduleCalendar from '@/store/calendar/moduleCalendar.js'
import moduleSummons from '@/store/summons/moduleSummons.js'
import Datepicker from 'vuejs-datepicker'
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import vSelect from 'vue-select'

require('vue-simple-calendar/static/css/default.css')

export default {
  components: {
    CalendarView,
    CalendarViewHeader,
    Datepicker,
    flatPickr,
    vSelect
  },
  data () {
    return {
      showDate: new Date(),
      id: 0,
      title: '',
      startDate: '',
      endDate: '',
      labelLocal: 'none',
      sel_contacts: '',
      sel_groups: '',
      sel_location: '',
      configdateTimePicker: {
        enableTime: true,
        dateFormat: 'd/m/Y h:i K'
      },
      invalid_date: false,
      url: '',
      calendarView: 'month',

      activePromptAddEvent: false,
      isAddOrEdit: false,

      calendarViewTypes: [
        {
          label: 'Month',
          val: 'month'
        },
        {
          label: 'Week',
          val: 'week'
        },
        {
          label: 'Year',
          val: 'year'
        }
      ]
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
    events () {
      return this.$store.state.calendar.events
    },
    validForm () {
      return this.title !== '' && this.startDate !== '' && this.endDate !== '' && Date.parse(this.endDate) - Date.parse(this.startDate) >= 0 && !this.errors.has('event-url')
    },
    disabledDatesTo () {
      return { to: new Date(this.startDate) }
    },
    disabledDatesFrom () {
      return { from: new Date(this.endDate) }
    },
    windowWidth () {
      return this.$store.state.windowWidth
    }
  },
  methods: {
    addEvent () {
      this.$validator.validateAll().then(result => {
        if (result) {
          let eventObj = {}

          // let current_date = new Date()

          // var fullDate = this.startDate
          // fullDate = fullDate.split(' ');

          // var date = fullDate[0].split(/\//);
          // var time = fullDate[1];

          // var newDate = date[1] + '/' + date[0] + '/' + date[2] + ' ' + time;
          // var eventDate = new Date(newDate);

          // if (this.current_date > eventDate)
          // {
          //   this.invalid_date = true
          //   return 
          // }

          // this.invalid_date = false

          if (this.isAddOrEdit) {
            eventObj = {
              'message': this.title,
              'start_date': this.startDate,
              'end_date': this.endDate,
              'sel_groups': this.sel_groups,
              'sel_contacts': this.sel_contacts,
              'sel_location': this.sel_location,
            }

            this.$store.dispatch('calendar/createEvent', eventObj)
          } else {
            eventObj = {
              'id': this.id,
              'message': this.title,
              'start_date': this.startDate,
              'end_date': this.endDate,
              'sel_groups': this.sel_groups,
              'sel_contacts': this.sel_contacts,
              'sel_location': this.sel_location,
            }

            this.$store.dispatch('calendar/updateEvent', eventObj)
          }
        }
      })
    },
    cancelEvent () {
      if (this.isAddOrEdit){
        this.activePromptAddEvent = false
      }

      this.$store.dispatch('calendar/deleteEvent', this.id)
    },
    updateMonth (val) {
      this.showDate = this.$refs.calendar.getIncrementedPeriod(val)
    },
    openAddNewEvent (date) {
      this.isAddOrEdit = true
      this.startDate = date
      this.endDate = date
      this.sel_location = ''
      this.sel_contacts = []
      this.sel_groups = []
      this.title = ''
      this.id = 0
      this.activePromptAddEvent = true
    },
    openEditEvent (event) {      
      this.isAddOrEdit = false
      const e = this.$store.getters['calendar/getEvent'](event.id)
      this.id = e.id
      this.title = e.title
      this.startDate = new Date(e.startDate)
      this.endDate = new Date(e.endDate)
      this.sel_location = e.sel_location
      this.sel_contacts = e.sel_contacts
      this.sel_groups = e.sel_groups
      this.activePromptAddEvent = true
    },
    eventDragged (event, date) {
      this.$store.dispatch('calendar/eventDragged', {event, date})
    }
  },
  created () {
    if (!moduleCalendar.isRegistered) {
      this.$store.registerModule('calendar', moduleCalendar)
      moduleCalendar.isRegistered = true
    }

    this.$store.dispatch('calendar/fetchEvents')

    if (!moduleSummons.isRegistered) {
      this.$store.registerModule('summons', moduleSummons)
      moduleSummons.isRegistered = true
    }

    this.$store.dispatch('summons/fetchLocationOptions')
    this.$store.dispatch('summons/fetchGroupOptions')
    this.$store.dispatch('summons/fetchContactOptions')
  },
  beforeDestroy () {
    this.$store.unregisterModule('calendar')
    moduleCalendar.isRegistered = false
  }
}
</script>

<style lang="scss">
@import "@sass/vuexy/apps/simple-calendar.scss";
</style>
