<template>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto d-flex justify-content-between align-items-center">
                <h1>Announcements</h1>
                <router-link class="btn btn-success" :to="{ name: [routeNames.announcement_create][0] }">Testing</router-link>
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

import * as routeNames from '~/config/route-names'
import axios from 'axios'

export default {
    name: 'admin-announcement',

    data: () => ({
        routeNames
    }),

    mounted() {
        this.$store.dispatch('announcements/fetchAnnouncements')
    },

    methods: {
        test() {
            console.log( [routeNames.admin_login] )
        }
    }
}

</script>