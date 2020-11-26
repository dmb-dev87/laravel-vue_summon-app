<template>
  <div id="component-chat-log" class="m-8" v-if="summonsData">
      <div v-for="(summon, index) in summonsData" class="msg-grp-container" :key="index">

        <!-- If previous msg is older than current time -->
        <template v-if="summonsData[index-1]">
            <vs-divider v-if="!isSameDay(summon.start_date, summonsData[index-1].start_date)" class="msg-time">
                <span>{{ toDate(summon.start_date) }}</span>
            </vs-divider>
            <div class="spacer mt-8" v-if="!hasSentPreviousMsg(summonsData[index-1].is_sent, summon.is_sent)"></div>
        </template>

        <div class="flex items-start flex-row-reverse">
          <div 
            style="min-width: 300px; min-height: 60px; cursor:pointer;" 
            class="msg break-words relative shadow-md rounded py-3 px-4 mb-2 rounded-lg max-w-sm" 
            :class="{'bg-primary-gradient text-white': summon.is_sent, 'border border-solid border-transparent bg-white': !summon.is_sent}"  
            @click="$router.push('summon_history').catch(() => {})"> 
              <span>{{ summon.message }} </span>
              <p>Location: {{ summon.location_name }} </p>
              <p>Due to: {{ summon.end_date }} </p>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default{
  components: {
  },
  computed: {
    summonsData () {
      return this.$store.getters['summons/summonData']
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
