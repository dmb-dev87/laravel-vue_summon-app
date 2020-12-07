<template>
  <vx-card no-shadow>
    <vs-input type="email" class="w-full mb-base" label-placeholder="Email Address" v-model="email_address" name="email_address" v-validate="'required'" />
    <span class="text-danger text-sm" v-show="errors.has('email_address')">{{ errors.first('email_address') }}</span>

    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="mr-4 mt-2" type="border" color="primary" @click="integrateWithGoogle">
        <i class="fab fa-google mr-1"></i>
        <span class="truncate">With Google</span>
      </vs-button>
      <vs-button class="mr-4 mt-2" type="border" color="primary" @click="integrateWithOutlook">
        <i class="fab fa-microsoft mr-1"></i>
        With Outlook
      </vs-button>
      <vs-button class="mt-2">Start Integrate</vs-button>
    </div>
  </vx-card>
</template>

<script>
import outlookAuth from '@/authServices/outlook_oAuth'

export default {
  components: {
  },
  data () {
    return {
      email_address: "",
    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  created () {
    outlookAuth.configure()
  },
  methods: {
    integrateWithGoogle () {
      this.$gAuth.signIn()
        .then(GoogleUser => {
          let authResponse = GoogleUser.getAuthResponse()

          const obj = {
            email_type: 'google',
            access_token: authResponse.access_token,
          }

          this.$store.dispatch('auth/emailConfigure', obj)
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
    },
    async integrateWithOutlook () {
      let idToken  = await outlookAuth.login()

      if (idToken)
      {
        this.$vs.loading()

        let accessToken = await outlookAuth.acquireToken()

        if (accessToken) {
          const obj = {
            email_type: 'outlook',
            access_token: accessToken
          }

          this.$store.dispatch('auth/emailConfigure', obj)
            .then(response => {
              this.$vs.loading.close()
              this.$vs.notify({
                title: response.data.status === 200 ? 'Success' : 'Error',
                text: response.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: response.data.status === 200 ? 'success' : 'danger'
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
      else 
      {
        this.$vs.notify({
          title: 'Error',
          text: "Email configure failed",
          iconPack: 'feather',
          icon: 'icon-alert-circle',
          color: 'danger'
        })
      }
    }
  }
}
</script>
