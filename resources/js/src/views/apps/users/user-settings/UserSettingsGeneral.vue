<template>
  <vx-card no-shadow>
    <!-- Info -->
    <vx-input-group class="mb-base form-element-demo">
      <vs-input class="w-full" label-placeholder="Username" v-model="dataUsername" name="item-user-name" v-validate="'required'" />
      <span class="text-danger text-sm" v-show="errors.has('item-user-name')">{{ errors.first('item-user-name') }}</span>
    </vx-input-group>

    <vx-input-group class="mb-base form-element-demo">
      <vs-input class="w-full" label-placeholder="Name" v-model="dataName" name="item-name" v-validate="'required'" />
      <span class="text-danger text-sm" v-show="errors.has('item-name')">{{ errors.first('item-name') }}</span>
    </vx-input-group>

    <!-- Languages -->
    <div class="mb-base">
      <label class="text-sm">Languages</label>
      <v-select v-model="lang_known" multiple :closeOnSelect="false" :options="langOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
    </div>
    
    <!-- SWITCH -->
    <label class="text-sm">First Email</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="dataEmail" name="item-email" v-validate="'required'" />
      <!-- <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Email </span>
          <vs-switch v-model="activeUserInfo.email_val1" />
        </div>
      </template> -->
      <span class="text-danger text-sm" v-show="errors.has('item-email')">{{ errors.first('item-email') }}</span>
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
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="dataPN1" class="w-full" name="item-phone-number1" v-validate="'required'" />
      <span class="text-danger text-sm" v-show="errors.has('item-phone-number1')">{{ errors.first('item-phone-number1') }}</span>
    </vx-input-group>
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
    <vx-input-group class="mb-base form-element-demo">      
      <vs-input v-model="dataPN2" class="w-full"/>
    </vx-input-group>
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
    <vx-input-group class="mb-base form-element-demo">      
      <vs-input v-model="dataPN3" class="w-full"/>
    </vx-input-group>
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
  created () {    
    let activeUserInfo = this.$store.state.AppActiveUser

    const { id, user_name, email, email2, name, phone_number1, phone_number2, phone_number3 } = JSON.parse(JSON.stringify(activeUserInfo))
    
    this.dataUsername = user_name
    this.dataId = id
    this.dataEmail = email
    this.dataEmail2 = email2
    this.dataName = name
    this.dataPN1 = phone_number1
    this.dataPN2 = phone_number2
    this.dataPN3 = phone_number3
  },
  methods: {
    resetInfo() {
      let activeUserInfo = this.$store.state.AppActiveUser

      const { id, user_name, email, email2, name, phone_number1, phone_number2, phone_number3 } = JSON.parse(JSON.stringify(activeUserInfo))
      
      this.dataUsername = user_name
      this.dataId = id
      this.dataEmail = email
      this.dataEmail2 = email2
      this.dataName = name
      this.dataPN1 = phone_number1
      this.dataPN2 = phone_number2
      this.dataPN3 = phone_number3
    },
    saveUser() {      
      this.$validator.validateAll().then(result => {
        if (result) {
          this.$vs.loading()

          const obj = {
            id: this.dataId,
            user_name: this.dataUsername,
            name: this.dataName,
            email: this.dataEmail,
            email2: this.dataEmail2 === null ? '' : this.dataEmail2, 
            phone_number1: this.dataPN1,
            phone_number2: this.dataPN2 === null ? '' : this.dataPN2,
            phone_number3: this.dataPN3 === null ? '' : this.dataPN3,
          }

          this.$store.dispatch('auth/updateUser', obj)
            .then(() => {
              this.$vs.notify({
                title: 'Success',
                text: "Save user settings success.",
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
                text: "Save user settings failed.",
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger'
              })
            })
        }
      })
    }
  }
}
</script>
