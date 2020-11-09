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
        <h4>{{ Object.entries(this.data).length === 0 ? "ADD NEW" : "UPDATE" }} GROUP</h4>
        <feather-icon icon="XIcon" @click.stop="isSidebarActiveLocal = false" class="cursor-pointer"></feather-icon>
    </div>
    <vs-divider class="mb-0"></vs-divider>

    <component :is="scrollbarTag" class="scroll-area--data-list-add-new" :settings="settings" :key="$vs.rtl">

      <div class="p-6">

        <!-- NAME -->
        <vs-input label="Group Name" v-model="dataName" class="mt-5 w-full" name="item-name" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-name')">{{ errors.first('item-name') }}</span>        

        <div class="mb-base mt-6">
          <label class="text-sm">Contacts</label>
          <v-select v-model="sel_contact" multiple :closeOnSelect="false" :options="contactlists" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        </div>
        
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
import vSelect from 'vue-select'

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
    VuePerfectScrollbar,
    vSelect
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
      sel_contact: [
        'Felecia Rower', 
        'Beats HeadPhones', 
      ],

      contactlists: [
        { label: 'Felecia Rower',  value: '1'  },
        { label: 'Beats HeadPhones',  value: '2'  },
        { label: 'Adalberto Granzin',   value: '3'   },
        { label: 'Altec Lansing',  value: '4'  },
        { label: 'Joaquina Weisenborn',   value: '5'   },
        { label: 'Verla Morgano',   value: '6'   },
        { label: 'Margot Henschke', value: '7' },
        { label: 'Sal Piggee', value: '8' },
        { label: 'Altec Lansing', value: '9' },
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
      // this.$validator.validateAll().then(result => {
      //   if (result) {
      //     const obj = {
      //       id: this.dataId,
      //       name: this.dataName,
      //       group: this.dataGroup, 
      //       location: this.dataLocation, 
      //       email1: this.dataEmail1,
      //       email2: this.dataEmail2, 
      //       phonenumber1: this.dataPN1,
      //       phonenumber2: this.dataPN2,
      //       phonenumber3: this.dataPN3,
      //     }

      //     if (this.dataId !== null && this.dataId >= 0) {
      //       this.$store.dispatch('dataList/updateItem', obj).catch(err => { console.error(err) })
      //     } else {
      //       delete obj.id
      //       obj.popularity = 0
      //       this.$store.dispatch('dataList/addItem', obj).catch(err => { console.error(err) })
      //     }

      //     this.$emit('closeSidebar')
      //     this.initValues()
      //   }
      // })
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
