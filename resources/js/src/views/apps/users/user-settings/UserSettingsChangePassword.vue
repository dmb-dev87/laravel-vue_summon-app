<template>
  <vx-card no-shadow>

    <vs-input type="password" class="w-full mb-base" label-placeholder="Old Password" v-model="old_password" />
    
    <vs-input type="password" class="w-full mb-base" label-placeholder="New Password" v-model="new_password" />
    <span class="text-danger text-sm">{{ errors.first('password') }}</span>

    <vs-input type="password" class="w-full mb-base" label-placeholder="Confirm Password" v-model="confirm_new_password" />
    <span class="text-danger text-sm">{{ errors.first('confirm_password') }}</span>

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
      old_password: '',
      new_password: '',
      confirm_new_password: ''
    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    },
    validateForm () {
      return !this.errors.any() && this.old_password !== '' && this.new_password !== '' && this.confirm_new_password !== ''
    }
  },
  method: {
    resetValue () {
      this.old_password = ''
      this.new_password = ''
      this.confirm_new_password = ''
    },
    changePassword () {

    }
  }
}
</script>
