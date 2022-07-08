<template>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto d-flex justify-content-between align-items-center">
                <h1>Positions</h1>
                <router-link :to="{ name: 'admin.positions.create' }">
                    <v-button type="primary">
                        Add Position
                    </v-button>
                </router-link>
            </div>
        </div>
        
        <!-- Contents -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'admin-user-positions',
    
    created(){
        this.$store.dispatch('positions/fetchPositions')
    },
}

</script>