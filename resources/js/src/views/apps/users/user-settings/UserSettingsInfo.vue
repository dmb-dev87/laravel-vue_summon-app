<template>
  <vx-card no-shadow>
    <div class="flex flex-wrap items-center justify-start">
      <vs-button class="mt-2">Start Integrate</vs-button>
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
        { label: 'Arabic',   value: 'arabic'   },
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
