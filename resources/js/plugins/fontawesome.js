import Vue from 'vue'
import { library, config } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {
  faUser, faLock, faSignOutAlt, faCog, faPlus, faBell, faHome, faHospitalUser, faClipboardList, faFileContract, faHeadphones
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub
} from '@fortawesome/free-brands-svg-icons'

config.autoAddCss = false

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faPlus, faBell, faHome, faHospitalUser, faClipboardList, faFileContract, faHeadphones
)

Vue.component('Fa', FontAwesomeIcon)
