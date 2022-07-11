<template>
  <div class="main-layout">
    <navbar />
    <sidebar />
    <div class="container-fluid mt-4">
      <child />
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
import Sidebar from '~/components/Sidebar'

export default {
  name: 'MainLayout',

  components: {
    Navbar,
    Sidebar
  }
}
</script>
