<template>
  <vx-card no-shadow>
    <!-- Info -->
    <vs-input class="w-full mb-base" label-placeholder="Username" v-model="username"></vs-input>
    <vs-input class="w-full mb-base" label-placeholder="Name" v-model="name"></vs-input>
    <!-- SWITCH -->
    <label class="text-sm">First Email</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="email1" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Email </span>
          <vs-switch v-model="switch1" />
        </div>
      </template>
    </vx-input-group>
    <label class="text-sm">Second Email</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="email2" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Email </span>
          <vs-switch v-model="switch2" />
        </div>
      </template>
    </vx-input-group>
    <label class="text-sm">First Phone Number</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="phonenumber1" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
      </template>
    </vx-input-group>
    <label class="text-sm">Second Phone Number</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="phonenumber2" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
      </template>
    </vx-input-group>
    <label class="text-sm">Third Phone Number</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="phonenumber3" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="phoneswitch1" />
        </div>
      </template>
    </vx-input-group>
    
    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2">Save Changes</vs-button>
      <vs-button class="ml-4 mt-2" type="border" color="warning">Reset</vs-button>
    </div>
  </vx-card>
</template>

<script>
export default {
  data () {
    return {
      username: 'johny_01',
      name: this.$store.state.AppActiveUser.displayName,
      email1: 'john1@admin.com',
      switch1 : true,
      email2: 'john2@gmail.com',
      switch2 : false,
      phonenumber1: '1234567890',
      phoneswitch1: true,
      phonenumber2: '1234567890',
      phoneswitch2: false,
      phonenumber3: '1234567890',
      phoneswitch3: false,
      // company: 'SnowMash Technologies Pvt Ltd'
    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  }
}
</script>
