<!-- =========================================================================================
  File Name: AddNewDataSidebar.vue
  Description: Add New Data - Sidebar component
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


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
        <vs-input label="Email1" v-model="dataEmail1" class="mt-5 w-full" name="item-email1" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-email1')">{{ errors.first('item-email1') }}</span>  

        <vx-input-group class="mb-base mt-4 form-element-demo">
          <template slot="prepend">
            <div class="prepend-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Email  </span>
              <vs-switch v-model="permission.email1.email"/>
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
              <vs-switch v-model="permission.email2.email"/>
            </div>
          </template>
        </vx-input-group>

         <!-- PHONE NUMBER -->
        <vs-input label="Phone Number1" v-model="dataPN1" class="mt-5 w-full" name="item-pn1" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-pn1')">{{ errors.first('item-pn1') }}</span>
        <vx-input-group class="mb-base mt-4 form-element-demo">
          <template slot="append">
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Voice  </span>
              <vs-switch v-model="permission.phonenumber1.voice"/>
            </div>
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> SMS </span>
              <vs-switch v-model="permission.phonenumber1.sms"/>
            </div>
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Whatsapp </span>
              <vs-switch v-model="permission.phonenumber1.whatsapp"/>
            </div>
          </template>
        </vx-input-group>

         <!-- PHONE NUMBER -->
        <vs-input label="Phone Number2" v-model="dataPN2" class="mt-5 w-full" name="item-pn2" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-pn2')">{{ errors.first('item-pn2') }}</span>

        <vx-input-group class="mb-base mt-4 form-element-demo">
          <template slot="append">
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Voice  </span>
              <vs-switch v-model="permission.phonenumber2.voice"/>
            </div>
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> SMS </span>
              <vs-switch v-model="permission.phonenumber2.sms"/>
            </div>
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Whatsapp </span>
              <vs-switch v-model="permission.phonenumber2.whatsapp"/>
            </div>
          </template>
        </vx-input-group>

         <!-- PHONE NUMBER -->
        <vs-input label="Phone Number3" v-model="dataPN3" class="mt-5 w-full" name="item-pn3" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-pn3')">{{ errors.first('item-pn3') }}</span>

        <vx-input-group class="mb-base mt-4 form-element-demo">
          <template slot="append">
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Voice  </span>
              <vs-switch v-model="permission.phonenumber3.voice"/>
            </div>
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> SMS </span>
              <vs-switch v-model="permission.phonenumber3.sms"/>
            </div>
            <div class="append-text">
              <span class="mr-2 text-sm" style="color: #626262;"> Whatsapp </span>
              <vs-switch v-model="permission.phonenumber3.whatsapp"/>
            </div>
          </template>
        </vx-input-group>

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
      dataEmail1: '',
      dataEmail2: '',
      dataPN1: '',
      dataPN2: '',
      dataPN3: '',
      dataGroup: null,
      dataLocation: null,
      permission: { 
        email1: { 
          email: false,
        },
        email2: { 
          email: false,
        },
        phonenumber1: {
          sms: true, 
          voice: true, 
          whatsapp: true
        },
        phonenumber2: {
          sms: true, 
          voice: false, 
          whatsapp: false
        },
        phonenumber3: {
          sms: true, 
          voice: true, 
          whatsapp: true
        },
      },

      group_choices: [
        { label: 'IT Department',  value: '1'  },
        { label: 'Sales Team',     value: '2'  },
        { label: 'Management Team',  value: '3'  },
        { label: 'Broadcast',      value: '4'  },
      ],

      location_choices: [
        { label: '1st Floot meeting room',  value: '1'  },
        { label: 'Main office ',     value: '2'     },
        { label: 'CE office ',    value: '3'    },
        { label: 'IT senior Manager office',      value: '4'     },
      ],

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
        const { id, group, location, email1, email2, name, phonenumber1, phonenumber2, phonenumber3 } = JSON.parse(JSON.stringify(this.data))        
        this.dataId = id
        this.dataGroup = group
        this.dataLocation = location
        this.dataEmail1 = email1
        this.dataEmail2 = email2
        this.dataName = name
        this.dataPN1 = phonenumber1
        this.dataPN2 = phonenumber2
        this.dataPN3 = phonenumber3
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
      if (this.data.id) return
      this.dataId = null
      this.dataGroup = ''
      this.dataLocation = ''
      this.dataEmail1 = ''
      this.dataEmail2 = ''
      this.dataName = ''
      this.dataPN1 = ''
      this.dataPN2 = ''
      this.dataPN3 = ''
    },
    submitData () {
      this.$validator.validateAll().then(result => {
        if (result) {
          const obj = {
            id: this.dataId,
            name: this.dataName,
            group: this.dataGroup, 
            location: this.dataLocation, 
            email1: this.dataEmail1,
            email2: this.dataEmail2, 
            phonenumber1: this.dataPN1,
            phonenumber2: this.dataPN2,
            phonenumber3: this.dataPN3,
          }

          if (this.dataId !== null && this.dataId >= 0) {
            this.$store.dispatch('dataList/updateItem', obj).catch(err => { console.error(err) })
          } else {
            delete obj.id
            obj.popularity = 0
            this.$store.dispatch('dataList/addItem', obj).catch(err => { console.error(err) })
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
    // height: calc(var(--vh, 1vh) * 100 - 4.3rem);
    height: calc(var(--vh, 1vh) * 100 - 16px - 45px - 82px);

    &:not(.ps) {
      overflow-y: auto;
    }
}
</style>
