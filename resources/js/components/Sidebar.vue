<template>
    <div v-if="user" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar-wrapper">
        <!-- <router-link class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" :to="'/'">
            <span class="fs-4">iPhiTech Logo</span>
        </router-link>
        <hr> -->

        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Loop from menu object of user -->
            <li class="nav-item mb-1" v-for="menu in user.menu.side" v-if="menu.hasChildren">
                <div class="d-flex align-items-center">
                    <span class="icon-controller">
                        <fa :icon="menu.iconClass" />
                    </span>
                    <span class="main-item">
                        <a href="javascript:void(0)" :class="menu.class" data-bs-toggle="collapse" :data-bs-target="'#' + menu.toggleId" aria-expanded="false">{{ menu.name }}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"/></svg>
                        </a>
                    </span>
                </div>
                <div :id="menu.toggleId" class="collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1" v-for="submenu in menu.subMenus">
                        <li class="d-flex align-items-center">
                            <!-- <fa :icon="submenu.iconClass" /> -->
                            <router-link :class="submenu.class" class="sub-items" :to="{ name: submenu.routeName }">{{ submenu.name }}</router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mb-1 d-flex align-items-center" v-else>
                <span class="icon-controller">
                    <fa :icon="menu.iconClass" />
                </span>
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
.icon-controller {
    width: 20px;
}
#user-collapse .btn-toggle-nav,
#position-collapse .btn-toggle-nav,
#announcement-collapse .btn-toggle-nav,
#course-collapse .btn-toggle-nav {
    padding-left: 20px;
}
.sub-items {
    color: #adadad !important;
}

.main-item {
    width: 100%;
}
.main-item a {
    width: 100%;
}
.main-item svg {
    width: 5px;
    float: right;
    margin-top: 5px;
    fill: #fff;
}

</style>