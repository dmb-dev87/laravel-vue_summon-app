<template>
  <vx-card no-shadow>

    <!-- Bio -->
    <!-- <vs-textarea label="Bio" v-model="bio" placeholder="Your bio..." /> -->

    <!-- DOB -->
    <!-- <div class="mt-8">
      <label class="text-sm">Birth Date</label>
      <flat-pickr v-model="dob" :config="{ dateFormat: 'd F Y' }" class="w-full" />
    </div> -->

    <!-- Country -->
    <!-- <div class="mt-8">
      <label class="text-sm">Location</label>
      <v-select v-model="location" :options="locationOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
    </div>
    
    <div class="mt-8">
      <label class="text-sm">Group</label>
      <v-select v-model="group" :options="groupOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
    </div>

    <!-- Languages -->
    <!-- <div class="mt-8">
      <label class="text-sm">Languages</label>
      <v-select v-model="lang_known" multiple :closeOnSelect="false" :options="langOptions" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
    </div> -->

    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-start">
      <vs-button class="mt-2">Start Integrate</vs-button>
      <!-- <vs-button class="ml-4 mt-2" type="border" color="warning">Reset</vs-button> -->
    </div>
  </vx-card>
</template>

<script>
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import vSelect from 'vue-select'

export default {
  components: {
    flatPickr,
    vSelect
  },
  data () {
    return {
      bio: this.$store.state.AppActiveUser.about,
      dob: null,
      country: 'Bahrain',
      location: 'P.O. Box 948, Jidhafs',
      group: 'IT Manager', 
      lang_known: ['English', 'Arabic'],
      gender: 'male',      
      mobile: '',
      website: '',

      // Options
      locationOptions: [
        { label: '1st Floot meeting room',  value: '1'  },
        { label: 'Main office ',     value: '2'     },
        { label: 'CE office ',    value: '3'    },
        { label: 'IT senior Manager office',      value: '4'     },
      ],
      groupOptions: [
        { label: 'IT Department',  value: '1'  },
        { label: 'Sales Team',     value: '2'     },
        { label: 'Management Team',    value: '3'    },
        { label: 'Broadcast',      value: '4'     },
      ],
      langOptions: [
        { label: 'English',  value: 'english'  },
        // { label: 'Spanish',  value: 'spanish'  },
        // { label: 'French',   value: 'french'   },
        // { label: 'Russian',  value: 'russian'  },
        // { label: 'German',   value: 'german'   },
        { label: 'Arabic',   value: 'arabic'   },
        // { label: 'Sanskrit', value: 'sanskrit' }
      ]
    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  }
}
</script>
