<template>
    <div class="h-screen flex w-full bg-img">
        <div class="vx-col flex items-center justify-center flex-col sm:w-1/2 md:w-3/5 lg:w-3/4 xl:w-1/2 mx-auto text-center">
            <img src="@assets/images/pages/lock-screen.png" alt="graphic-not-authorized" class="mx-auto mb-4">
            <h1 class="sm:mx-0 mx-4 sm:mb-12 mb-8 text-5xl d-theme-heading-color">{{show_string}}</h1>
            <!-- <p class="sm:mx-0 mx-4 sm:mb-12 mb-8 d-theme-text-inverse">paraphonic unassessable foramination Caulopteris worral Spirophyton encrimson esparcet aggerate chondrule restate whistler shallopy biosystematy area bertram plotting unstarting quarterstaff.</p> -->
            <vs-button size="large" to="/">Back to Home</vs-button>
        </div>
    </div>
</template>

<script>
import moduleSummons from '@/store/summons/moduleSummons.js'

export default {
	data () {
		return {
			history_id: null,
			show_string: 'Sending the responde request to sender.',
		}
	},
  created () {
		this.history_id = this.$router.currentRoute.params.history_id
		if (!moduleSummons.isRegistered) {
      this.$store.registerModule('summons', moduleSummons)
      moduleSummons.isRegistered = true
		}

		this.$vs.loading()
		
		this.$store.dispatch('summons/emailResponse', this.history_id)
			.then(() => {
				this.$vs.loading.close()
				this.show_string = 'You have been responde to message!'
			})
			.catch((err) => {
				this.show_string = err
			})
  },
}
</script>