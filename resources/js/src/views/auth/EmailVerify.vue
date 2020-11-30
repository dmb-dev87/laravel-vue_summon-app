<template>
    <div class="h-screen flex w-full bg-img">
        <div class="vx-col w-4/5 sm:w-4/5 md:w-3/5 lg:w-3/4 xl:w-3/5 mx-auto self-center">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row">
                        <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
                            <img src="@assets/images/pages/forgot-password.png" alt="login" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center d-theme-dark-bg">
                            <div class="p-8">
                                <div class="vx-card__title mb-8">
                                    <h4 class="mb-4">Verify your mail account</h4>
                                    <p>Please enter your verification code in your email.</p>
                                </div>
                                <vs-input label-placeholder="Verification Code" v-model="verification_code" class="w-full mb-8" />

																<vs-button  type="border" class="mt-6">Resend</vs-button>
    														<vs-button class="float-right mt-6" @click="emailVerify" :disabled="!validateForm">Verify</vs-button>
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
			verification_code: '',
			token: '',
    }
	},
	created () {
		this.token = this.$router.currentRoute.params.token
	},
	computed: {
    validateForm () {
      return !this.errors.any() && this.verification_code !== ''
    }
	},
	methods: {
		emailVerify () {
			if (!this.validateForm) return

			this.$vs.loading()

      const payload = {
        verify_details: {
					token: this.token,
					verification_code: this.verification_code
        },
			}

			this.$store.dispatch('auth/emailVerify', payload)
				.then(() => {
          this.$vs.notify({
            title: 'Success',
            text: "Please login with your credentials.",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'success'
          })
          this.$vs.loading.close()
        })
        .catch(() => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Error',
            text: "Email verificatioin failed",
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })
		}
	}
}
</script>
