<template>
  <vx-card no-shadow>

    <vs-input type="password" class="w-full mb-base" label-placeholder="Old Password" v-model="old_password" name="old_password" v-validate="'required'" />
    <span class="text-danger text-sm" v-show="errors.has('old_password')">{{ errors.first('old_password') }}</span>
    
    <vs-input type="password" class="w-full mb-base" label-placeholder="New Password" v-model="new_password" name="new_password" v-validate="'required'" />
    <span class="text-danger text-sm" v-show="errors.has('new_password')">{{ errors.first('new_password') }}</span>

    <vs-input type="password" class="w-full mb-base" label-placeholder="Confirm Password" v-model="confirm_new_password" name="confirm_new_password" v-validate="'required'"/>
    <span class="text-danger text-sm" v-show="errors.has('confirm_new_password')">{{ errors.first('confirm_new_password') }}</span>

    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2" @click="changePassword" :disabled="!validateForm">Save Changes</vs-button>
      <vs-button class="ml-4 mt-2" type="border" color="warning" @click="resetValue">Reset</vs-button>
    </div>
  </vx-card>
</template>

<script>
export default {
  data () {
    return {
      dataId: null,
      old_password: '',
      new_password: '',
      confirm_new_password: ''
    }
  },
  computed: {
    validateForm () {
      return !this.errors.any() && this.old_password !== '' && this.new_password !== '' && this.confirm_new_password !== '' && this.new_password === this.confirm_new_password
    }
  },
  created () {
    this.dataId = this.$store.state.AppActiveUser.id
  },
  methods: {
    resetValue () {
      this.old_password = ''
      this.new_password = ''
      this.confirm_new_password = ''
    },
    changePassword () {
      if (this.dataId === null) return

      this.$validator.validateAll().then(result => {
        if (result) {
          this.$vs.loading()

          const obj = {
            old_password: this.old_password,
            new_password: this.new_password,
            confirm_password: this.confirm_new_password
          }

          this.$store.dispatch('auth/changePassword', obj)
            .then((response) => {
              this.$vs.notify({
                title: response.data.status === 200 ? 'Success' : 'Error',
                text: response.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: response.data.status === 200 ? 'success' : 'danger'
              })
              this.$vs.loading.close()
            })
            .catch(err => {
              this.$vs.loading.close()
              this.$vs.notify({
                title: 'Error',
                text: err.message,
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
