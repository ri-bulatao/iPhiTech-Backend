import store from '~/store'
import Cookies from 'js-cookie'

export default (to, from, next) => {
  if (!store.getters['auth/check']) {
    Cookies.set('intended_url', to.path)
    
    next({ name: 'admin.login' })

  } else {
    if( ! store.getters['auth/user'].is_admin ) {
      next({ name: 'admin.login' })
    }
    else {
      next()
    }
  }
}
