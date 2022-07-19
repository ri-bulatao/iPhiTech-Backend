<template>
  <div class="main-layout">
    <navbar />
    <sidebar />
    <div class="container-fluid main-container">
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
  },
}
</script>
<style>
  .main-container {
    margin-top: 3.5rem !important;
  }

  .custom-container {
    margin-left: 280px;
    width: calc(100% - 280px);
    padding: 2rem;
  }
</style>