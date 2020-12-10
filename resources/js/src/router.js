import Vue from 'vue'
import Router from 'vue-router'
import auth from '@/auth/authService'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: '/',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '',
      component: () => import('./layouts/main/Main.vue'),
      children: [
        {
          path: '/',
          redirect: '/summon'
        },
        {
          path: '/summon',
          name: 'summon',
          component: () => import('@/views/apps/summon/summon-home/Summon.vue'),
          meta: {
            rule: 'user',
            no_scroll: true,
            authRequired: true
          }
        },
        {
          path: '/calendar',
          name: 'calendar-simple-calendar',
          component: () => import('@/views/apps/calendar/SimpleCalendar.vue'),
          meta: {
            rule: 'user',
            no_scroll: true,
            authRequired: true
          }
        },
        {
          path: '/user-list',
          name: 'app-user-list',
          component: () => import('@/views/apps/users/user-list/UserListView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'User' },
              { title: 'List', active: true }
            ],
            pageTitle: 'User List',
            rule: 'admin',
            authRequired: true
          }
        },
        {
          path: '/contact',
          name: 'contact-list',
          component: () => import('@/views/apps/contacts/contact-list/ContactListView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Contact List', active: true }
            ],
            pageTitle: 'Contact List',
            rule: 'user',
            authRequired: true
          }
        },
        {
          path: '/location',
          name: 'location-list',
          component: () => import('@/views/apps/locations/locations-list/LocationListView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Location List', active: true }
            ],
            pageTitle: 'Location List',
            rule: 'user',
            authRequired: true
          }
        },
        {
          path: '/group',
          name: 'group-list',
          component: () => import('@/views/apps/groups/group-list/GroupListView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Group List', active: true }
            ],
            pageTitle: 'Group List',
            rule: 'user',
            authRequired: true
          }
        },
        {
          path: '/summon_history/:id',
          name: 'summon-history',
          component: () => import('@/views/apps/summon/summon-history/SummonHistories.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Summon History', active: true }
            ],
            pageTitle: 'Summon History',
            rule: 'user',
            authRequired: true
          }
        },
        {
          path: '/activate',
          name: 'activate-user',
          component: () => import('@/views/apps/users/activate-code/ActivateTwilioCode.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Activate', active: true }
            ],
            pageTitle: 'Activate',
            rule: 'admin',
            authRequired: true
          }
        },
        {
          path: '/user-settings',
          name: 'user-settings',
          component: () => import('@/views/apps/users/user-settings/UserSettings.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'User Settings', active: true }
            ],
            pageTitle: 'Settings',
            rule: 'user',
            authRequired: true
          }
        },
      ]
    },
    {
      path: '',
      component: () => import('@/layouts/full-page/FullPage.vue'),
      children: [
        {
          path: '/callback',
          name: 'auth-callback',
          component: () => import('@/views/Callback.vue'),
          meta: {
            rule: 'user'
          }
        },
        {
          path: '/login',
          name: 'login',
          component: () => import('@/views/auth/login/Login.vue'),
          meta: {
            rule: 'user'
          }
        },
        {
          path: '/register',
          name: 'register',
          component: () => import('@/views/auth/register/Register.vue'),
          meta: {
            rule: 'user'
          }
        },
        {
          path: '/forgot-password',
          name: 'forgot-password',
          component: () => import('@/views/auth/ForgotPassword.vue'),
          meta: {
            rule: 'user'
          }
        },
        {
          path: '/email-verify/:token',
          name: 'email-verify',
          component: () => import('@/views/auth/EmailVerify.vue'),
          meta: {
            rule: 'user'
          },
        },
        {
          path: '/reset-password:token',
          name: 'reset-password',
          component: () => import('@/views/auth/ResetPassword.vue'),
          meta: {
            rule: 'user'
          }
        },
        {
          path: '/error-404',
          name: 'error-404',
          component: () => import('@/views/error/Error404.vue'),
          meta: {
            rule: 'user'
          }
        },
        {
          path: '/error-500',
          name: 'error-500',
          component: () => import('@/views/error/Error500.vue'),
          meta: {
            rule: 'user'
          }
        },
        {
          path: '/not-authorized',
          name: 'not-authorized',
          component: () => import('@/views/error/NotAuthorized.vue'),
          meta: {
            rule: 'user'
          }
        },
      ]
    },
    {
      path: '*',
      redirect: '/error-404'
    }
  ]
})

router.afterEach(() => {
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

router.beforeEach((to, from, next) => {
  if (to.meta.authRequired) {
    if (!(auth.isAuthenticated())) {
      router.push({ path: '/login', query: { to: to.path } })
    }
  }

  return next()
})

export default router
