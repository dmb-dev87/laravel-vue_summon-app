<template>
  <div id="data-list-list-view" class="data-list-container">

    <user-edit-view :isSidebarActive="userEditView" @closeSidebar="toggleUserEditView" :data="userData" />

    <vs-table ref="table" multiple v-model="selected" pagination :max-items="itemsPerPage" search :data="users">

      <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">

        <div class="flex flex-wrap-reverse items-center data-list-btn-container">

          <!-- ACTION - DROPDOWN -->
          <vs-dropdown vs-trigger-click class="dd-actions cursor-pointer mr-4 mb-4">

            <div class="p-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer flex items-center justify-center text-lg font-medium w-32 w-full">
              <span class="mr-2">Actions</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>

            <vs-dropdown-menu>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <span>Activate</span>
                </span>
              </vs-dropdown-item>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <span>Deactivate</span>
                </span>
              </vs-dropdown-item>

            </vs-dropdown-menu>
          </vs-dropdown>
        </div>

        <!-- ITEMS PER PAGE -->
        <vs-dropdown vs-trigger-click class="cursor-pointer mb-4 mr-4 items-per-page-handler">
          <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
            <span class="mr-2">{{ currentPage * itemsPerPage - (itemsPerPage - 1) }} - {{ users.length - currentPage * itemsPerPage > 0 ? currentPage * itemsPerPage : users.length }} of {{ queriedItems }}</span>
            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
          </div>
          <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
          <vs-dropdown-menu>

            <vs-dropdown-item @click="itemsPerPage=4">
              <span>4</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=10">
              <span>10</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=15">
              <span>15</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=20">
              <span>20</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <template slot="thead">
        <vs-th sort-key="name">Name</vs-th>
        <vs-th sort-key="group" class="hidden sm:table-cell">Status</vs-th>        
        <vs-th sort-key="email" class="hidden sm:table-cell">Email1</vs-th>
        <vs-th sort-key="email2" class="hidden sm:table-cell">Email2</vs-th>
        <vs-th sort-key="phone_number1" class="hidden sm:table-cell">Phone Number1</vs-th>
        <vs-th sort-key="phone_number2" class="hidden sm:table-cell">Phone Number2</vs-th>
        <vs-th sort-key="phone_number3" class="hidden sm:table-cell">Phone Number3</vs-th>
        <vs-th sort-key="role_name" class="hidden sm:table-cell">Role</vs-th>
        
        <vs-th>Action</vs-th>
      </template>

        <template slot-scope="{data}">
          <tbody>
            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

              <vs-td>
                <p class="product-name font-medium truncate">{{ tr.name }}</p>
              </vs-td>

              <vs-td class="hidden sm:table-cell">
                <vs-chip :color="getUserStatusColor(tr.status)" class="product-group">{{ tr.status }}</vs-chip>
                <!-- <p class="product-group" :color="getOrderStatusColor(tr.status)">{{ tr.status }}</p> -->
              </vs-td>

              <vs-td class="hidden sm:table-cell">
                <p class="product-email">{{ tr.email }}</p>
              </vs-td>

              <vs-td class="hidden sm:table-cell">
                <p class="product-email">{{ tr.email2 }}</p>
              </vs-td>

              <vs-td class="hidden sm:table-cell">
                <p class="product-phonenumber">{{ tr.phone_number1 }}</p>
              </vs-td>

              <vs-td class="hidden sm:table-cell">
                <p class="product-phonenumber">{{ tr.phone_number2 }}</p>
              </vs-td>

              <vs-td class="hidden sm:table-cell">
                <p class="product-phonenumber">{{ tr.phone_number3 }}</p>
              </vs-td>

              <vs-td class="hidden sm:table-cell">
                <p class="product-role">{{ tr.role_name }}</p>
              </vs-td>

              <vs-td class="whitespace-no-wrap">
                <feather-icon icon="EditIcon" svgClasses="w-5 h-5 hover:text-primary stroke-current" @click.stop="editData(tr)" />
                <feather-icon icon="TrashIcon" svgClasses="w-5 h-5 hover:text-danger stroke-current" class="ml-2" @click.stop="deleteData(tr.id)" />
              </vs-td>
            </vs-tr>
          </tbody>
        </template>
    </vs-table>
  </div>  
</template>


<script>
import UserEditView from './UserEditView.vue'
import moduleUser from '@/store/user/moduleUser.js'

export default {
  components: {
    UserEditView
  },
  data () {
    return {
      selected: [],
      itemsPerPage: 4,
      isMounted: false,

      // User Update View Sidebar
      userEditView: false,
      userData: {},
    }
  },
  computed: {
    currentPage () {
      if (this.isMounted) {
        return this.$refs.table.currentx
      }
      return 0
    },
    users () {
      return this.$store.state.users.users
    },
    queriedItems () {
      return this.$refs.table ? this.$refs.table.queriedResults.length : this.users.length
    }
  },
  methods: {
    deleteData (id) {
      this.$store.dispatch('dataList/removeItem', id).catch(err => { console.error(err) })
    },
    editData (data) {
      this.userData = data
      this.toggleUserEditView(true)
    },
    toggleUserEditView (val = false) {
      this.userEditView = val
    },
    getUserStatusColor (status) {
      if (status === 'Activate')   return 'primary'
      if (status === 'Deactivate') return 'danger'
      return 'primary'
    },
  },
  created () {
    if (!moduleUser.isRegistered) {
      this.$store.registerModule('users', moduleUser)
      moduleUser.isRegistered = true
    }
    this.$store.dispatch('users/fetchUserList')
  },
  mounted () {
    this.isMounted = true
  },
  // beforeDestroy () {
  //   this.$store.unregisterModule('users')
  // },
}
</script>

<style lang="scss">
#data-list-list-view {
  .vs-con-table {

    /*
      Below media-queries is fix for responsiveness of action buttons
      Note: If you change action buttons or layout of this page, Please remove below style
    */
    @media (max-width: 689px) {
      .vs-table--search {
        margin-left: 0;
        max-width: unset;
        width: 100%;

        .vs-table--search-input {
          width: 100%;
        }
      }
    }

    @media (max-width: 461px) {
      .items-per-page-handler {
        display: none;
      }
    }

    @media (max-width: 341px) {
      .data-list-btn-container {
        width: 100%;

        .dd-actions,
        .btn-add-new {
          width: 100%;
          margin-right: 0 !important;
        }
      }
    }

    .product-name {
      max-width: 23rem;
    }

    .vs-table--header {
      display: flex;
      flex-wrap: wrap;
      margin-left: 1.5rem;
      margin-right: 1.5rem;
      > span {
        display: flex;
        flex-grow: 1;
      }

      .vs-table--search{
        padding-top: 0;

        .vs-table--search-input {
          padding: 0.9rem 2.5rem;
          font-size: 1rem;

          &+i {
            left: 1rem;
          }

          &:focus+i {
            left: 1rem;
          }
        }
      }
    }

    .vs-table {
      border-collapse: separate;
      border-spacing: 0 1.3rem;
      padding: 0 1rem;

      tr{
          box-shadow: 0 4px 20px 0 rgba(0,0,0,.05);
          td{
            padding: 20px;
            &:first-child{
              border-top-left-radius: .5rem;
              border-bottom-left-radius: .5rem;
            }
            &:last-child{
              border-top-right-radius: .5rem;
              border-bottom-right-radius: .5rem;
            }
          }
          td.td-check{
            padding: 20px !important;
          }
      }
    }

    .vs-table--thead{
      th {
        padding-top: 0;
        padding-bottom: 0;

        .vs-table-text{
          text-transform: uppercase;
          font-weight: 600;
        }
      }
      th.td-check{
        padding: 0 15px !important;
      }
      tr{
        background: none;
        box-shadow: none;
      }
    }

    .vs-table--pagination {
      justify-content: center;
    }
  }
}
</style>
