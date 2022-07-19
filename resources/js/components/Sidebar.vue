<template>
    <div v-if="user" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar-wrapper">
        <router-link class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" :to="'/'">
            <span class="fs-4">iPhiTech Logo</span>
        </router-link>
        <hr>

        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Loop from menu object of user -->
            <li class="nav-item mb-1" v-for="menu in user.menu.side" v-if="menu.hasChildren">
                <div class="d-flex align-items-center">
                    <fa :icon="menu.iconClass" />
                    <a href="javascript:void(0)" :class="menu.class" data-bs-toggle="collapse" :data-bs-target="'#' + menu.toggleId" aria-expanded="false">{{ menu.name }}</a>
                </div>
                <div :id="menu.toggleId" class="collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1" v-for="submenu in menu.subMenus">
                        <li class="d-flex align-items-center">
                            <fa :icon="submenu.iconClass" />
                            <router-link :class="submenu.class" :to="{ name: submenu.routeName }">{{ submenu.name }}</router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mb-1 d-flex align-items-center" v-else>
                <fa :icon="menu.iconClass" />
                <router-link :to="{ name: menu.routeName }" :class="menu.class">{{ menu.name }}</router-link>
            </li>
        </ul>
        <!-- <hr>
        <div class="dropdown">
            <a href="javascript:void(0)" id="dropdownUser" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                <li><a href="javascript:void(0)">Profile</a></li>
                <li><a href="javascript:void(0)">Settings</a></li>
                <li><a href="javascript:void(0)">Logout</a></li>
            </ul>
        </div> -->
    </div>
</template>

<script>
import * as routeNames from '~/config/route-names'
import { mapGetters } from 'vuex'

export default {
    name: 'sidebar',

    data: () => ({
        routeNames
    }),

    computed: mapGetters({
        user: 'auth/user'
    })
}

</script>

<style scoped>
.sidebar-wrapper {
    width: 280px; 
    height: calc(100vh - 50px); 
    position:fixed;
}
</style>