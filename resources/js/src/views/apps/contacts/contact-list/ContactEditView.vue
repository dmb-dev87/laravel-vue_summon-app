<template>
  <vs-sidebar click-not-close position-right parent="body" default-index="1" color="primary" class="add-new-data-sidebar items-no-padding" spacer v-model="isSidebarActiveLocal">
    <div class="mt-6 flex items-center justify-between px-6">
        <h4>{{ Object.entries(this.data).length === 0 ? "ADD NEW" : "UPDATE" }} USER</h4>
        <feather-icon icon="XIcon" @click.stop="isSidebarActiveLocal = false" class="cursor-pointer"></feather-icon>
    </div>
    <vs-divider class="mb-0"></vs-divider>

    <component :is="scrollbarTag" class="scroll-area--data-list-add-new" :settings="settings" :key="$vs.rtl">

      <div class="p-6">

        <!-- NAME -->
        <vs-input label="Name" v-model="dataName" class="mt-5 w-full" name="item-name" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-name')">{{ errors.first('item-name') }}</span>

        <!-- EMAIL1 -->
        <vs-input label="Email1" v-model="dataEmail" class="mt-5 w-full" name="item-email" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-email')">{{ errors.first('item-email') }}</span>  

        <vx-input-group class="mb-base mt-4 form-element-demo">
          <template slot="prepend">
            <div class="prepend-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Email  </span>
              <vs-switch v-model="dataEmailVal1"/>
            </div>
          </template>
        </vx-input-group>    

        <!-- EMAIL2 -->
        <vs-input label="Email2" v-model="dataEmail2" class="mt-5 w-full" name="item-email2" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-email2')">{{ errors.first('item-email2') }}</span>

        <vx-input-group class="mb-base mt-4 form-element-demo">
          <template slot="prepend">
            <div class="prepend-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Email  </span>
              <vs-switch v-model="dataEmailVal2"/>
            </div>
          </template>
        </vx-input-group>

         <!-- PHONE NUMBER -->
        <vs-input label="Phone Number1" v-model="dataPN1" class="mt-5 w-full" name="item-pn1" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-pn1')">{{ errors.first('item-pn1') }}</span>
        <div class="vx-row mt-5">
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
            <vs-switch v-model="phoneVoice1" />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
            <vs-switch v-model="phoneSMS1" />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
            <vs-switch v-model="phoneWhatsapp1" />
          </div>      
        </div>

        <!-- PHONE NUMBER -->
        <vs-input label="Phone Number2" v-model="dataPN2" class="mt-5 w-full" name="item-pn2" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-pn2')">{{ errors.first('item-pn2') }}</span>
        <div class="vx-row mt-5">
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
            <vs-switch v-model="phoneVoice2" />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
            <vs-switch v-model="phoneSMS2" />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
            <vs-switch v-model="phoneWhatsapp2" />
          </div>      
        </div>

         <!-- PHONE NUMBER -->
        <vs-input label="Phone Number3" v-model="dataPN3" class="mt-5 w-full" name="item-pn3" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-pn3')">{{ errors.first('item-pn3') }}</span>
        <div class="vx-row mt-5">
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
            <vs-switch v-model="phoneVoice3" />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
            <vs-switch v-model="phoneSMS3" />
          </div>
          <div class="vx-col sm:w-1/2 md:w-1/2 flex mb-5">
            <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
            <vs-switch v-model="phoneWhatsapp3" />
          </div>      
        </div>

        <span class="text-danger text-sm" v-show="errors.has('item-location')">{{ errors.first('item-location') }}</span>
        
      </div>
    </component>

    <div class="flex flex-wrap items-center p-6" slot="footer">
      <vs-button class="mr-6" @click="submitData" :disabled="!isFormValid">Submit</vs-button>
      <vs-button type="border" color="danger" @click="isSidebarActiveLocal = false">Cancel</vs-button>
    </div>
  </vs-sidebar>
</template>

<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar'

export default {
  props: {
    isSidebarActive: {
      type: Boolean,
      required: true
    },
    data: {
      type: Object,
      default: () => {}
    }
  },
  components: {
    VuePerfectScrollbar
  },
  data () {
    return {
      dataId: null,
      dataName: '',
      dataEmail: '',
      dataEmail2: '',
      dataPN1: '',
      dataPN2: '',
      dataPN3: '',
      dataEmailVal1: false,
      dataEmailVal2: false,
      phoneVoice1: false,
      phoneSMS1: false,
      phoneWhatsapp1: false,
      phoneVoice2: false,
      phoneSMS2: false,
      phoneWhatsapp2: false,
      phoneVoice3: false,
      phoneSMS3: false,
      phoneWhatsapp3: false,

      settings: { // perfectscrollbar settings
        maxScrollbarLength: 60,
        wheelSpeed: .60
      }
    }
  },
  watch: {
    isSidebarActive (val) {
      if (!val) return
      if (Object.entries(this.data).length === 0) {
        this.initValues()
        this.$validator.reset()
      } else {
        const { id, group, location, email, email2, name, phone_number1, phone_number2, phone_number3, email_val1, email_val2, phone_voice1, phone_sms1, phone_whatsapp1, phone_voice2, phone_sms2, phone_whatsapp2, phone_voice3, phone_sms3, phone_whatsapp3 } = JSON.parse(JSON.stringify(this.data))
        this.dataId = id
        this.dataGroup = group
        this.dataLocation = location
        this.dataEmail = email
        this.dataEmail2 = email2
        this.dataName = name
        this.dataPN1 = phone_number1
        this.dataPN2 = phone_number2
        this.dataPN3 = phone_number3
        this.dataEmailVal1 = email_val1
        this.dataEmailVal2 = email_val2
        this.phoneVoice1 = phone_voice1
        this.phoneSMS1 = phone_sms1
        this.phoneWhatsapp1 = phone_whatsapp1
        this.phoneVoice2 = phone_voice2
        this.phoneSMS2 = phone_sms2
        this.phoneWhatsapp2 = phone_whatsapp2
        this.phoneVoice3 = phone_voice3
        this.phoneSMS3 = phone_sms3
        this.phoneWhatsapp3 = phone_whatsapp3

        this.initValues()
      }
    }
  },
  computed: {
    isSidebarActiveLocal: {
      get () {
        return this.isSidebarActive
      },
      set (val) {
        if (!val) {
          this.$emit('closeSidebar')
        }
      }
    },
    isFormValid () {
      // return !this.errors.any() && this.dataName && this.dataCategory && this.dataPrice > 0
      return true;
    },
    scrollbarTag () { return this.$store.getters.scrollbarTag }
  },
  methods: {
    initValues () {
      if (this.data.id) 
        return

      this.dataId = null
      this.dataGroup = ''
      this.dataLocation = ''
      this.dataEmail1 = ''
      this.dataEmail2 = ''
      this.dataName = ''
      this.dataPN1 = ''
      this.dataPN2 = ''
      this.dataPN3 = ''
      this.dataEmailVal1 = false
      this.dataEmailVal2 = false
      this.phoneVoice1 = false
      this.phoneSMS1 = false
      this.phoneWhatsapp1 = false
      this.phoneVoice2 = false
      this.phoneSMS2 = false
      this.phoneWhatsapp2 = false
      this.phoneVoice3 = false
      this.phoneSMS3 = false
      this.phoneWhatsapp3 = false
    },
    submitData () {
      this.$validator.validateAll().then(result => {
        if (result) {
          const obj = {
            id: this.dataId,
            name: this.dataName,
            email: this.dataEmail,
            email_val1: this.dataEmailVal1,
            email2: this.dataEmail2, 
            email_val2: this.dataEmailVal2,
            phone_number1: this.dataPN1,
            phone_voice1: this.phoneVoice1,
            phone_sms1: this.phoneSMS1,
            phone_whatsapp1: this.phoneWhatsapp1,
            phone_number2: this.dataPN2,
            phone_voice2: this.phoneVoice2,
            phone_sms2: this.phoneSMS2,
            phone_whatsapp2: this.phoneWhatsapp2,
            phone_number3: this.dataPN3,
            phone_voice3: this.phoneVoice3,
            phone_sms3: this.phoneSMS3,
            phone_whatsapp3: this.phoneWhatsapp3,
          }

          if (this.dataId !== null && this.dataId >= 0) {
            this.$store.dispatch('contacts/updateContact', obj).catch(err => { console.error(err) })
          } else {
            delete obj.id
            this.$store.dispatch('contacts/createContact', obj).catch(err => { console.error(err) })
          }

          this.$emit('closeSidebar')
          this.initValues()
        }
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.add-new-data-sidebar {
  ::v-deep .vs-sidebar--background {
    z-index: 52010;
  }

  ::v-deep .vs-sidebar {
    z-index: 52010;
    width: 400px;
    max-width: 90vw;

    .img-upload {
      margin-top: 2rem;

      .con-img-upload {
        padding: 0;
      }

      .con-input-upload {
        width: 100%;
        margin: 0;
      }
    }
  }
}

.scroll-area--data-list-add-new {
    height: calc(var(--vh, 1vh) * 100 - 16px - 45px - 82px);

    &:not(.ps) {
      overflow-y: auto;
    }
}
</style>
