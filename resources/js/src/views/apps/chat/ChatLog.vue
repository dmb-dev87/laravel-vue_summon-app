<!-- =========================================================================================
    File Name: ChatLog.vue
    Description: Chat Application - Log of chat
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div id="component-chat-log" class="m-8" v-if="chatData">
        <div v-for="(msg, index) in chatData.msg" class="msg-grp-container" :key="index">

            <!-- If previous msg is older than current time -->
            <template v-if="chatData.msg[index-1]">
                <vs-divider v-if="!isSameDay(msg.time, chatData.msg[index-1].time)" class="msg-time">
                    <span>{{ toDate(msg.time) }}</span>
                </vs-divider>
                <div class="spacer mt-8" v-if="!hasSentPreviousMsg(chatData.msg[index-1].isSent, msg.isSent)"></div>
            </template>

            <div class="flex items-start" :class="[{'flex-row-reverse' : msg.isSent}]">

                <template v-if="index==1">
                    <vs-navbar collapse class="p-2">
                      <div slot="title">
                        <vs-navbar-title>
                          <span> (1 people unread) </span>
                          <span>Sent To</span>
                        </vs-navbar-title>
                      </div>

                      <vs-navbar-item index="0" style="color:black">
                        <a href="#">Felecia Rower</a>
                        <a href="#" class="ml-6">Phone1 : read</a>     
                        <a href="#" class="ml-6">Phone2 : read</a>     
                        <a href="#" class="ml-6">Phone3 : read</a>     
                      </vs-navbar-item>

                      <vs-navbar-item index="1">
                        <a href="#">Joaquina Weisenborn</a>                        
                        
                        <a href="#" class="ml-6">Phone1 : read (replied "I can not go to the office today")</a>
                      </vs-navbar-item>
                      
                      <vs-navbar-item index="1">
                        <a href="#">Verla Morgano</a>                         
                        
                        <a href="#" class="ml-6">Phone1 : read</a>                                           
                        <a href="#" class="ml-6">Phone2 : unread</a>                   
                      </vs-navbar-item>

                    </vs-navbar>

                    <div class="msg break-words relative rounded rounded-lg max-w-sm mb-2" style="min-width: 300px; min-height: 60px;">
                        <statistics-card-line
                          hideChart
                          icon="ActivityIcon"
                          icon-right
                          statisticTitle="1:45"
                          color="danger" />
                    </div>
                </template>

                <template v-if="index!=1">
                    <vs-navbar collapse class="p-2">
                      <div slot="title">
                        <vs-navbar-title>
                          <span> (2 people unread) </span>
                          <span>Sent To</span>
                        </vs-navbar-title>
                      </div>

                      <vs-navbar-item index="0">
                        <a href="#">Felecia Rower</a>
                        <a href="#" class="ml-6">Email1 : read</a>
                        <a href="#" class="ml-6">Email2 : read</a>
                        <a href="#" class="ml-12">Replied : "I can not reach office today."</a>
                        
                        <a href="#" class="ml-6">Phone1</a>
                        <a href="#" class="ml-12">SMS: read, Whatsapp : read</a>                        
                        <a href="#" class="ml-6">Phone2</a>
                        <a href="#" class="ml-12">SMS: read, Whatsapp : read</a>
                      </vs-navbar-item>

                      <vs-navbar-item index="1">
                        <a href="#">Joaquina Weisenborn</a>

                        <a href="#" class="ml-6">Email1 : read</a>
                        <a href="#" class="ml-6">Email2 : read</a>
                        
                        <a href="#" class="ml-6">Phone1</a>
                        <a href="#" class="ml-12">SMS: read, Whatsapp : read</a>                        
                        <a href="#" class="ml-6">Phone2</a>
                        <a href="#" class="ml-12">SMS: read, Whatsapp : read</a>
                      </vs-navbar-item>
                      
                      <vs-navbar-item index="1">
                        <a href="#">Verla Morgano</a>   
                        
                        <a href="#" class="ml-6">Email1 : read</a>
                        <a href="#" class="ml-6">Email2 : read</a>
                        
                        <a href="#" class="ml-6">Phone1</a>
                        <a href="#" class="ml-12">SMS: read, Whatsapp : read</a>
                        <a href="#" class="ml-12">Replied : "I can not reach office today."</a>
                      </vs-navbar-item>

                    </vs-navbar>

                    <div style="min-width: 300px; min-height: 60px;" class="msg break-words relative shadow-md rounded py-3 px-4 mb-2 rounded-lg max-w-sm" :class="{'bg-primary-gradient text-white': msg.isSent, 'border border-solid border-transparent bg-white': !msg.isSent}">
                        <span>{{ msg.textContent }} </span>
                        <p>Location: Main office </p>
                        <p>Due to: 10/11 16:34 </p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
export default{
  components: {
    StatisticsCardLine
  },
  props: {
    userId: {
      type: Number,
      required: true
    }
  },
  computed: {
    chatData () {
      return this.$store.getters['chat/chatDataOfUser'](this.userId)
    },
    activeUserImg () {
      return this.$store.state.AppActiveUser.photoURL
    },
    senderImg () {
      return (isSentByActiveUser) => {
        if (isSentByActiveUser) return this.$store.state.AppActiveUser.photoURL
        else return this.$store.getters['chat/contact'](this.userId).photoURL
      }
    },
    hasSentPreviousMsg () {
      return (last_sender, current_sender) => last_sender === current_sender
    }
  },
  methods: {
    isSameDay (time_to, time_from) {
      const date_time_to = new Date(Date.parse(time_to))
      const date_time_from = new Date(Date.parse(time_from))
      return date_time_to.getFullYear() === date_time_from.getFullYear() &&
                date_time_to.getMonth() === date_time_from.getMonth() &&
                date_time_to.getDate() === date_time_from.getDate()
    },
    toDate (time) {
      const locale = 'en-us'
      const date_obj = new Date(Date.parse(time))
      const monthName = date_obj.toLocaleString(locale, {
        month: 'short'
      })
      return `${date_obj.getDate()  } ${   monthName}`
    },
    scrollToBottom () {
      this.$nextTick(() => {
        this.$parent.$el.scrollTop = this.$parent.$el.scrollHeight
      })
    }
  },
  updated () {
    this.scrollToBottom()
  },
  mounted () {
    this.scrollToBottom()
  }
}
</script>
