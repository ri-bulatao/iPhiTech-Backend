<template>
  <div class="main-layout">
    <navbar />
    <sidebar />
    <div class="container-fluid custom-container">
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
<style>
  .custom-container {
    margin-top: 3.5rem !important;
  }
</style>