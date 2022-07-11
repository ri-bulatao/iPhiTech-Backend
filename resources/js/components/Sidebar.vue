<template>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar-wrapper">
        <router-link class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" :to="'/'">
            <span class="fs-4">Dashboard</span>
        </router-link>
        <hr>
        <!-- For Admins -->
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Users -->
            <li class="nav-item mb-1" v-if="admin">
                <router-link class="nav-link rounded btn-toggle align-items-center collapsed text-white" data-bs-toggle="collapse" data-bs-target="#users-collapse" aria-expanded="false" :to="'#'">User</router-link>
                <div id="users-collapse" class="collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                        <li>
                            <router-link class="nav-link rounded text-white" :to="'#'">User List</router-link>
                        </li>
                        <li>
                            <router-link class="nav-link rounded text-white" :to="'#'">Create User</router-link>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Positions -->
            <li class="nav-item mb-1" v-if="admin">
                <router-link :to="'#'" class="nav-link rounded btn-toggle align-items-center collapsed text-white" data-bs-toggle="collapse" data-bs-target="#positions-collapse" aria-expanded="false">Position</router-link>
                <div id="positions-collapse" class="collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                        <li>
                            <router-link class="nav-link rounded text-white" :to="{ name: [routeNames.position_list] }">Position List</router-link>
                        </li>
                        <li>
                            <router-link class="nav-link rounded text-white" :to="{ name: [routeNames.position_create] }">Create Position</router-link>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Announcements -->
            <li class="nav-item mb-1" v-if="admin">
                <router-link :to="'#'" class="nav-link rounded btn-toggle align-items-center collapsed text-white" data-bs-toggle="collapse" data-bs-target="#announcement-collapse" aria-expanded="false">Announcements</router-link>
                <div id="announcement-collapse" class="collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                        <li>
                            <router-link class="nav-link rounded text-white" :to="{ name: [routeNames.announcement_list] }">Announcements List</router-link>
                        </li>
                        <li>
                            <router-link class="nav-link rounded text-white" :to="{ name: [routeNames.announcement_edit] }">Create Announcement</router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mb-1" v-else>
                <router-link :to="{ name: [routeNames.front_announcements] }" class="nav-link text-white align-items-center rounded">Announcements</router-link>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="javascript:void(0)" id="dropdownUser" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                <li><a href="javascript:void(0)">Profile</a></li>
                <li><a href="javascript:void(0)">Settings</a></li>
                <li><a href="javascript:void(0)">Logout</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
import * as routeNames from '~/config/route-names'
export default {
    name: 'sidebar',

    data: () => ({
        routeNames,
        admin: true
    }),

    mounted() {
        this.routeNames = routeNames
    }
}

</script>

<style scoped>
.sidebar-wrapper {
    width: 280px; 
    height: calc(100vh - 50px); 
    position:fixed;
}
</style>