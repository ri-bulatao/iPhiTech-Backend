function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

import * as routeNames from '~/config/route-names';

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  // Admin Pages
  { path: '/admin/login', name: 'admin.login', component: page('admin/login.vue') },
  { path: '/admin', name: 'admin.dashboard', component: page('admin/dashboard.vue'), 
  children: [
    {
      path: '',
      redirect: 'announcement'
    },
    {
      path: 'announcement',
      name: 'admin.announcements',
      component: page('admin/announcement/AdminAnnouncement.vue'),
      children: [
        {
          path: '',
          redirect: 'list'
        },
        {
          path: 'list',
          name: 'admin.announcements.list',
          component: page('admin/announcement/List.vue')
        },
        {
          path: 'single/:id',
          name: 'admin.announcements.single',
          component: page('admin/announcement/Single.vue')
        },
        {
          path: 'create',
          name: 'admin.announcements.create',
          component: page('admin/announcement/Create.vue')
        },
        {
          path: 'edit/:id',
          name: 'admin.announcements.edit',
          component: page('admin/announcement/Edit.vue')
        }
      ]
    },
    {
      path: 'handbook',
      name: 'handbook',
      component: page('handbook/index.vue'),
      children: [
        {
          path: '',
          redirect: 'pages'
        },
        {
          path: 'pages',
          name: 'handbook.pages',
          component: page('handbook/pages.vue'),
          children: [
            {
              path: 'view/:id',
              name: 'handbook.pages.view',
              component: page('handbook/view.vue')
            }
          ]
        },
        
      ]
    },
    {
      path: 'position',
      name: [routeNames.admin_position],
      component: page('admin/position/AdminUserPosition.vue'),
      children: [
        {
          path: '',
          redirect: 'list'
        },
        {
          path: 'list',
          name: [routeNames.position_list],
          component: page('admin/position/List.vue')
        },
        {
          path: 'single/:id',
          name: [routeNames.position_single],
          component: page('admin/position/Single.vue')
        },
        {
          path: 'create',
          name: [routeNames.position_create],
          component: page('admin/position/Create.vue')
        }
      ]
    }
  ] },
  

  // User Pages
  { path: '/user', name: 'user.dashboard', component: page('users/dashboard.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  {
    path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ]
  },

  { path: '*', component: page('errors/404.vue') }
]
