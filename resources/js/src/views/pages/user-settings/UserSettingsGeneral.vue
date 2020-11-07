<template>
  <vx-card no-shadow>
    <!-- Info -->
    <vs-input class="w-full mb-base" label-placeholder="Username" v-model="profile.username"></vs-input>
    <vs-input class="w-full mb-base" label-placeholder="Name" v-model="profile.name"></vs-input>
    <!-- SWITCH -->
    <label class="text-sm">First Email</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="profile.email1.email" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Email </span>
          <vs-switch v-model="profile.email1.permission.email" />
        </div>
      </template>
    </vx-input-group>
    <label class="text-sm">Second Email</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="profile.email2.email" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Email </span>
          <vs-switch v-model="profile.email2.permission.email" />
        </div>
      </template>
    </vx-input-group>
    <label class="text-sm">First Phone Number</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="profile.phonenumber1.phonenumber" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="profile.phonenumber1.permission.voice" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="profile.phonenumber1.permission.sms" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="profile.phonenumber1.permission.whatsapp" />
        </div>
      </template>
    </vx-input-group>
    <label class="text-sm">Second Phone Number</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="profile.phonenumber2.phonenumber" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="profile.phonenumber2.permission.voice" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="profile.phonenumber2.permission.sms" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="profile.phonenumber2.permission.whatsapp" />
        </div>
      </template>
    </vx-input-group>
    <label class="text-sm">Third Phone Number</label>
    <vx-input-group class="mb-base form-element-demo">
      <vs-input v-model="profile.phonenumber3.phonenumber" />
      <template slot="append">
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Voice Message </span>
          <vs-switch v-model="profile.phonenumber3.permission.voice" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> SMS </span>
          <vs-switch v-model="profile.phonenumber3.permission.sms" />
        </div>
        <div class="append-text">
          <span class="mr-5 text-sm" style="color: #626262;"> Whatsapp </span>
          <vs-switch v-model="profile.phonenumber3.permission.whatsapp" />
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
      profile : { 
        username: 'johny_01', 
        name: "John Steve", 
        email1 : { 
          email : 'john1@admin.com', 
          permission : { 
            email: true
          }
        },
        email2 : { 
          email : 'john2@admin.com', 
          permission : { 
            email: false
          }
        },
        phonenumber1 : { 
          phonenumber : '1111111111', 
          permission : { 
            sms: true,
            whatsapp: true,
            voice: true,
          }
        },
        phonenumber2 : { 
          phonenumber : '2222222222', 
          permission : { 
            sms: false,
            whatsapp: true,
            voice: false,
          }
        },
        phonenumber3 : { 
          phonenumber : '33333333333', 
          permission : { 
            sms: false,
            whatsapp: false,
            voice: false,
          }
        },
      }      
    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  }
}
</script>
