<template>
    <div class="h-screen flex w-full bg-img">
        <div class="vx-col sm:w-3/5 md:w-3/5 lg:w-3/4 xl:w-3/5 mx-auto self-center">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row">
                        <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
                            <img src="@assets/images/pages/reset-password.png" alt="login" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center  d-theme-dark-bg">
                            <div class="p-8">
                                <div class="vx-card__title mb-8">
                                    <h4 class="mb-4">Reset Password</h4>
                                    <p>Please enter your new password.</p>
                                </div>
                                <vs-input type="email" label-placeholder="Email" v-model="email" class="w-full mb-6" />
                                <vs-input type="password" label-placeholder="Password" v-model="new_password" class="w-full mb-6" />
                                <vs-input type="password" label-placeholder="Confirm Password" v-model="confirm_password" class="w-full mb-8" />

                                <div class="flex flex-wrap justify-between flex-col-reverse sm:flex-row">
                                    <vs-button type="border" to="/login" class="w-full sm:w-auto mb-8 sm:mb-auto mt-3 sm:mt-auto">Go Back To Login</vs-button>
                                    <vs-button class="w-full sm:w-auto" @click="resetPassword">Reset</vs-button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
export default {
  data () {
    return {
			token: '',
      email: '',
      new_password: '',
      confirm_password: ''
    }
	},
	created () {
		this.token = this.$route.params.token
	},
  methods: {
		resetPassword() {
			this.$vs.loading()

			const payload = {
				token: this.token,
				email: this.email,
				password: this.new_password,
				password_confirmation: this.confirm_password
			}
			
			this.$store.dispatch('auth/resetPassword', payload)
        .then((result) => { 
          this.$vs.loading.close()
          this.$vs.notify({
            title: result.status === 200 ? 'Success' : 'Error',
            text: result.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: result.status === 200 ? 'success' : 'danger'
          })
        })
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
