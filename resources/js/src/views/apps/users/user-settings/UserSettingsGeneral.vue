<template>
  <vx-card no-shadow>
    <!-- Info -->
    <vs-input class="w-full mb-base" label-placeholder="Username" v-model="dataUsername"></vs-input>
    <vs-input class="w-full mb-base" label-placeholder="Name" v-model="dataName"></vs-input>

    <!-- Languages -->
    <div class="mb-base">
      <label class="text-sm">Languages</label>
      <v-select v-model="lang_known" multiple :closeOnSelect="false" :options="langOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
    </div>
    <!-- SWITCH -->
    <label class="text-sm">First Email</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="dataEmail" />
      <!-- <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Email </span>
          <vs-switch v-model="activeUserInfo.email_val1" />
        </div>
      </template> -->
    </vx-input-group>
    <label class="text-sm">Second Email</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="dataEmail2" />
      <!-- <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Email </span>
          <vs-switch v-model="activeUserInfo.email_val2" />
        </div>
      </template> -->
    </vx-input-group>
    <label class="text-sm">First Phone Number</label>
    <vs-input v-model="dataPN1" class="w-full mb-base"/>
    <!-- <div class="vx-row mt-5">
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="activeUserInfo.phone_voice1" />
        </div>
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="activeUserInfo.phone_sms1" />
        </div>
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="activeUserInfo.phone_whatsapp1" />
        </div>      
    </div> -->
    <label class="text-sm">Second Phone Number</label>
    <vs-input v-model="dataPN2" class="w-full mb-base"/>
    <!-- <div class="vx-row mt-5">
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="activeUserInfo.phone_voice2" />
        </div>
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="activeUserInfo.phone_sms2" />
        </div>
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="activeUserInfo.phone_whatsapp2" />
        </div>      
    </div> -->
    <label class="text-sm">Third Phone Number</label>
    <vs-input v-model="dataPN3" class="w-full mb-base"/>
    <!-- <div class="vx-row mt-5">
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="activeUserInfo.phone_voice3" />
        </div>
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="activeUserInfo.phone_sms3" />
        </div>
        <div class="vx-col sm:w-1/2 md:w-1/3 flex mb-5">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="activeUserInfo.phone_whatsapp3" />
        </div>      
    </div> -->
    
    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2" @click="saveUser">Save Changes</vs-button>
      <vs-button class="ml-4 mt-2" type="border" color="warning" @click="resetInfo">Reset</vs-button>
    </div>
  </vx-card>
</template>

<script>
import vSelect from 'vue-select'
import moduleUser from '@/store/user/moduleUser.js'

export default {
  props: {
    userInfo: {
      type: Object,
      default: () => {}
    }
  },
  components: {
    vSelect
  },
  data () {
    return {
      dataId: null,
      dataUsername: '',
      dataName: '',
      dataEmail: '',
      dataEmail2: '',
      dataPN1: '',
      dataPN2: '',
      dataPN3: '',
      lang_known: ['English', 'Arabic'],
      langOptions: [
        { label: 'English',  value: 'english'  },
        { label: 'Arabic',   value: 'arabic'   },
      ] 

    }
  },
  computed: {
    // activeUserInfo () {
    //   return this.$store.state.AppActiveUser
    // }
  },
  created () {
    this.activeUserInfo = this.$store.state.AppActiveUser
  },
  watch: {
    userInfo: function() {
      console.log("++++++++++++++++++++", this.data)
      const { id, user_name, email, email2, name, phone_number1, phone_number2, phone_number3 } = JSON.parse(JSON.stringify(this.data))
      this.dataUsername = user_name
      this.dataId = id
      this.dataEmail = email
      this.dataEmail2 = email2
      this.dataName = name
      this.dataPN1 = phone_number1
      this.dataPN2 = phone_number2
      this.dataPN3 = phone_number3
    }
  },
  methods: {
    resetInfo() {
      this.activeUserInfo = this.$store.state.AppActiveUser
    },
    saveUser() {
      this.$vs.loading()

      this.$store.dispatch('auth/upateUser', this.activeUserInfo)
        .then(() => {this.$vs.loading.close()})
        .catch(error => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Error',
            text: error.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })
    }
  }
}
</script>
