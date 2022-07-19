<template>
    <div class="container-fluid custom-container">
        <!-- Header -->
        <div class="row">
            <div class="col-sm-12 col-lg-12 d-flex justify-content-between align-items-center">
                <h1>Users</h1>
            </div>
        </div>
        
        <!-- Contents -->
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'admin-users',
    
    created(){
        this.$store.dispatch('users/fetchUsers')
        this.$store.dispatch('users/fetchCountries')
        this.$store.dispatch('positions/fetchPositions')
    },
}

</script>