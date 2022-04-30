import Vue from 'vue'
import VueRouter from 'vue-router'
import { isUserLoggedIn, getUserData, getHomeRouteForLoggedInUser } from '@/auth/utils'
import { canNavigate } from '@/libs/acl/routeProtection'



Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/dashboard',
      name: 'home',
      component: () => import('@/views/Home.vue'),
      meta: {
        action: 'read',
        resource: 'Auth',
        pageTitle: 'Home',
        breadcrumb: [
          {
            text: 'Home',
            active: true,
           
          },
        ],
      },
    },
    {
      path: '/roles-listar',
      name: 'roles-listar',
      component: () => import('@/views/gestionusuarios/roles/roles-listar/RolesListar.vue'),
      meta: {
        action: 'read',
        resource: 'Auth',
        pageTitle: 'Listado de Roles',
        breadcrumb: [
          {
            text: 'Listado de Roles',
            active: true,
          },
        ],
      },
    },
    {
      path: '/usuarios-listar',
      name: 'usuarios-listar',
      component: () => import('@/views/gestionusuarios/usuarios/usuarios-listar/UsuariosListar.vue'),
      meta: {
        action: 'read',
        resource: 'Auth',
        pageTitle: 'Listado de Usuarios',
        breadcrumb: [
          {
            text: 'Listado de Usuarios',
            active: true,
          },
        ],
      },
    },
    {
      path: '/second-page',
      name: 'second-page',
      component: () => import('@/views/SecondPage.vue'),
      meta: {
        action: 'read',
        subject: 'Auth',
        pageTitle: 'Second Page',
        breadcrumb: [
          {
            text: 'Second Page',
            active: true,
          },
        ],
      },
    },
    {
      path: '/login',
      name: 'auth-login',
      component: () => import('@/views/auth/Login.vue'),
      meta: {
        layout: 'full',
        resource: 'Auth',
        redirectIfLoggedIn: true,
      },
    },
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
        resource: 'Auth',

      },
    },
    {
      path: '*',
      redirect: 'error-404',
    },
  ],
})

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})


router.beforeEach((to, _, next) => {
  const isLoggedIn = isUserLoggedIn()

  // console.log("Esta logado:",isLoggedIn)
  // console.log("Navigate:",canNavigate(to))
  // console.log(to)

  if (!canNavigate(to)) {
    // Redirect to login if not logged in
    if (!isLoggedIn) return next({ name: 'auth-login' })

    // If logged in => not authorized
    return next({ name: 'error-404' })
  }
  // Redirect if logged in
  if (to.meta.redirectIfLoggedIn && isLoggedIn) {
    const userData = getUserData()
    // console.log(userData)
    next(getHomeRouteForLoggedInUser(userData ? userData.roles : null))
  }

  return next()
})


// router.beforeEach((to, _, next) => {
//   const isLoggedIn = isUserLoggedIn()

  
//   // if (!canNavigate(to)) {
//   //   // Redirect to login if not logged in
//   //   if (!isLoggedIn) return next({ name: 'auth-login' })

//   //   // If logged in => not authorized
//   //   return next({ name: 'roles-listar' })
//   // }

//   // Redirect if logged in
//   console.log(to)
//   console.log(to.meta.redirectIfLoggedIn)
//   console.log(isLoggedIn)
//   if (to.meta.redirectIfLoggedIn && isLoggedIn) {
  
//     const userData = getUserData()
//     console.log("aqui")
//     return next({name: 'home'})
//   }

//   return next()
// })



export default router
