<template>
    <div class="container-fluid row custom-container">
        <div class="col-lg-12">
            <div class="pb-3 mb-3 border-bottom">
                <h1>Announcements</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-4 m-auto" v-for="announcement in announcements" :key="announcement.id">
                    <div class="card px-3 mt-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ announcement.title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ announcement.pretty_created }}</h6>
                            <p class="card-text">{{ announcement.excerpt }}</p>
                            <router-link :to="{ name: 'front.announcement.single', params: { id: announcement.id } }" class="card-link">Read More</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

    name: 'announcement-landing',
    middleware: 'auth',
    computed: mapGetters({
        announcements: 'announcements/announcements'
    }),

    mounted() {
        this.$store.dispatch('announcements/fetchAnnouncements')
    },

    metaInfo () {
        return { title: this.$t('Announcements Landing Page') }
    },
}
</script>