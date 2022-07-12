<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbar" class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <locale-dropdown />
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li> -->
        </ul>

        <ul class="navbar-nav ms-auto">

          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
               href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              <fa icon="bell" />
              <span class="position-absolute top-1 start-10 translate-middle badge rounded-pill badge-notification bg-danger">{{ notifications.length }}</span>
            </a>
            <div class="dropdown-menu">
              <a href="javascript:void(0)" @click="() => updateRedirect(notification)" class="dropdown-item ps-3" v-for="notification in notifications" :key="notification.id">{{ notification.title }}</a>
              <div class="dropdown-divider" />
              <router-link :to="{ name: 'front.notifications' }" class="dropdown-item ps-3">See all Notifications</router-link>
            </div>
          </li>

          <!-- Authenticated -->
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark"
               href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              <img :src="user.photo_url" class="rounded-circle profile-photo me-1">
              {{ user.name }}
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
                <fa icon="cog" fixed-width />
                {{ $t('settings') }}
              </router-link>
              
              <!-- Initial Need to Update to Menu Item to Sidebar -->
              <router-link :to="{ name: 'handbook' }" class="dropdown-item ps-3">
                <fa icon="cog" fixed-width />
                Handbook
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
            </div>
          </li>

          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                {{ $t('login') }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                {{ $t('register') }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import Swal from 'sweetalert2'
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import Pusher from 'pusher-js'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user',
    notifications: 'notifications/unreadNotifications'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },

    updateRedirect(notification) {
      let payload = {
        id: notification.id,
        title: notification.title,
        url: notification.url,
        read: ! notification.read
      }

      this.$store.dispatch('notifications/updateNotification', payload)
        .then(res => {
          this.$store.dispatch('notifications/fetchUnreadNotifications')
          this.$router.push(notification.url)
        })
        .catch(err => {
          Swal.fire({
            icon: 'error',
            title: 'Something went wrong!'
          })
        })
    }
  },

  created() {
    let pusher = new Pusher('3ac02751a4aa9ae8d60c', {
      cluster: 'ap1'
    })

    let channel = pusher.subscribe('posted-announcements');

    channel.bind('posted-announcements', async (data) => {
      console.log(data)
      let permission = await Notification.requestPermission()
      const notif = new Notification('New Announcement Posted', {
        body: 'Checkout the new announcement'
      })
      this.$store.dispatch('notifications/fetchUnreadNotifications')
      setTimeout(() => notif.close(), 4*1000);
    })
  },

  mounted() {
    this.$store.dispatch('notifications/fetchUnreadNotifications')
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}

.container {
  max-width: 1100px;
}
</style>
