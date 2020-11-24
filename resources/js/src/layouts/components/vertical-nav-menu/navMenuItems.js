/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
          url     => router path
          name    => name to display in sidebar
          slug    => router path name
          icon    => Feather Icon component/icon name
          tag     => text to display on badge
          tagColor  => class to apply on badge element
          i18n    => Internationalization
          submenu   => submenu of current item (current item will become dropdown )
                NOTE: Submenu don't have any icon(you can add icon if u want to display)
          isDisabled  => disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [
  {
    header: 'Apps',
    icon: 'PackageIcon',
    i18n: 'Apps',
    items: [
      {
        url: '/summon',
        name: 'Summon',
        slug: 'Summon',
        icon: 'MessageSquareIcon',
        i18n: 'Summon'
      },
      {
        url: '/calendar',
        name: 'Calendar',
        slug: 'calendar-simple-calendar',
        icon: 'CalendarIcon',
        tagColor: 'success',
        i18n: 'Calendar'
      },
      {
        url: '/contact',
        name: 'Contact',
        slug: 'Contact',
        icon: 'UsersIcon',
        i18n: 'Contact'
      },
      {
        url: '/group',
        name: 'Group',
        slug: 'Group',
        icon: 'LayersIcon',
        i18n: 'Group'
      },
      {
        url: '/location',
        name: 'Location',
        slug: 'Location',
        icon: 'LayoutIcon',
        i18n: 'Location'
      },
      {
        url: '/user-settings',
        slug: 'page-user-settings',
        name: 'User Settings',
        icon: 'SettingsIcon',
        i18n: 'UserSettings'
      },
      {
        url: 'activate',
        name: 'Activate',
        icon: 'LockIcon',
        slug: 'Activate',
        i18n: 'Activate'
      },
    ]
  },
  {
    header: 'Admin',
    icon: 'FileIcon',
    i18n: 'Admin',
    items: [
      {
        url: '/user-list',
        name: 'Users',
        slug: 'app-user-list',
        icon: 'UsersIcon',
        i18n: 'Users'
      },
    ]
  },
]

