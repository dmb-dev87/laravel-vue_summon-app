<template>
  <vx-card title="Activate Twilio Code">

    <div class="mb-base">
      <span>You can input twilio activate key here.</span>
    </div>

    <!-- Append Button -->
    <vx-input-group class="mb-base">
      <vs-input v-model="input2" />

      <template slot="append">
        <div class="append-text btn-addon">
          <vs-button color="primary">Activate</vs-button>
        </div>
      </template>
    </vx-input-group>
    <!-- /Append Button -->
  </vx-card>
</template>

<script>
export default {
  data () {
    return {
      input1: '',
      input2: '',
      input3: '',
      input4: ''
    }
  }
}
</script>
