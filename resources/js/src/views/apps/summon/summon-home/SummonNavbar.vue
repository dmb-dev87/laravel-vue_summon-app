<template>
    <div class="chat__header">
        <vs-navbar class="p-4 flex navbar-custom" color="white" type="flat" style="height: 52px;">
            <div class="relative flex mr-4">
                <feather-icon icon="ListIcon" class="mr-4 cursor-pointer" v-if="isSidebarCollapsed" @click.stop="$emit(`openContactsSidebar`)" />
            </div>
            <vs-spacer></vs-spacer>
        </vs-navbar>
    </div>
</template>

<script>
export default {
  props: {
    isSidebarCollapsed: {
      type: Boolean,
      required: true
    }
  },
  computed: {
  },
  methods: {
  }
}

</script>

