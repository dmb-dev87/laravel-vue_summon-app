export default [
  {
    header: 'Apps',
    icon: 'PackageIcon',
    i18n: 'Apps',
    rule: 'user',
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
    ]
  },
  {
    header: 'Admin',
    icon: 'FileIcon',
    i18n: 'Admin',
    rule: 'admin',
    items: [
      {
        url: '/activate',
        name: 'Activate',
        icon: 'LockIcon',
        slug: 'Activate',
        i18n: 'Activate'
      },
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

