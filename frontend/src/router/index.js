import { route } from 'quasar/wrappers'
import { createRouter, createMemoryHistory, createWebHistory, createWebHashHistory } from 'vue-router'
import routes from './routes'
import config from '../../config/env.js'

// console.log(config);
/*
 * If not building with SSR mode, you can
* directly export the Router instantiation;
*
* The function below can be async too; either use
* async/await or return a Promise which resolves
* with the Router instance.
*/

process.env.VUE_APP_BASE_URL = config.VUE_APP_BASE_URL

export default route(function (/* { store, ssrContext } */) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : (process.env.VUE_ROUTER_MODE === 'history' ? createWebHistory : createWebHashHistory)

  const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,

    // Leave this as is and make changes in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    history: createHistory(process.env.VUE_ROUTER_BASE)
    // history: createWebHashHistory(process.env.VUE_ROUTER_BASE)
  })

  Router.beforeEach((to, from, next) => {
    var api_token=localStorage.getItem('api_token');

    if (to.matched.some(record => record.meta.requiresAuth) && !api_token) {
      sessionStorage.setItem('redirectPath', to.path);
      next('/login')
      // next({ name: 'account-signin', query: { next: to.fullPath } })
    } else {
      next()
    }
  })

  return Router
})

