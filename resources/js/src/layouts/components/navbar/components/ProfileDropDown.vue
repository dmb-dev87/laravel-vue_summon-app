<template>
  <div class="the-navbar__user-meta flex items-center pl-5">

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <div class="text-right leading-tight hidden sm:block">
        <p class="font-semibold">Hi, {{ activeUserInfo.name }}</p>
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">
          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/summon').catch(() => {})">
              <feather-icon icon="MessageSquareIcon" svgClasses="w-4 h-4" />
              <span class="ml-2">Summon</span>
          </li>

          <vs-divider class="m-1" />

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout">
              <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
              <span class="ml-2">Logout</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>

<script>
export default {
  data () {
    return {

    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  methods: {
    logout () {
      if (localStorage.getItem('accessToken')) {
        localStorage.removeItem('accessToken')        
      }

      localStorage.setItem('localStorageKey', false)
      localStorage.removeItem('userInfo')
      this.$acl.change('Admin')

      this.$router.push('/login').catch(() => {})
    }
  }
}
</script>
