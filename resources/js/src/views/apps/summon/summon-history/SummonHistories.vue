<template>
	<div class="vx-row">
		<div :data="history" :key="index" v-for="(history, index) in histories" class="vx-col w-full mb-base">
			<vx-card :title="history.contact_name" action-buttons @refresh="closeCardAnimationDemo" style="overflow-y: auto; ">
				<table style="width:100%; min-width: 500px;" class="border-collapse">
					<tr>
						<th class="p-2 border border-solid d-theme-border-grey-light">Type</th>
						<th class="p-2 border border-solid d-theme-border-grey-light text-center">Voice Call</th>
						<th class="p-2 border border-solid d-theme-border-grey-light text-center">SMS</th>
						<th class="p-2 border border-solid d-theme-border-grey-light text-center">Whatsapp</th>						
						<th class="p-2 border border-solid d-theme-border-grey-light text-center">Email</th>
					</tr>
					<tr :data="tr" :key="indexTr" v-for="(tr, indexTr) in history.history_detail">
						<td class="p-2 border border-solid d-theme-border-grey-light">{{tr.type}}</td>
						<template v-if="tr.email">
							<td class="border border-solid d-theme-border-grey-light text-center"></td>
							<td class="border border-solid d-theme-border-grey-light text-center"></td>
							<td class="border border-solid d-theme-border-grey-light text-center"></td>
							<td class="p-2 border border-solid d-theme-border-grey-light text-center">{{tr.email}}</td>
						</template>							
						<template v-else>
							<td
								:data="td" :key="indexTd" v-for="(td, indexTd) in tr.phone"
								class="border border-solid d-theme-border-grey-light text-center"
							>
								{{td.status}}
							</td>
							<td class="p-2 border border-solid d-theme-border-grey-light text-center"></td>
						</template>
					</tr>
				</table>
			</vx-card>
		</div>
	</div>
</template>

<script>
import moduleSummons from '@/store/summons/moduleSummons.js'

export default {
	data () {
		return {
			summon_id: null,
			histories: [],
		}
	},
  methods: {
    closeCardAnimationDemo (card) {
      card.removeRefreshAnimation(3000)
    }
  },
  created () {
		this.summon_id = this.$router.currentRoute.params.id
		if (!moduleSummons.isRegistered) {
      this.$store.registerModule('summons', moduleSummons)
      moduleSummons.isRegistered = true
    }
		this.$store.dispatch('summons/fetchHistories', this.summon_id)
			.then((response) => {
				this.histories = response.data
			})
			.catch((err) => {
				console.error(err)
			})
  },
}
</script>
