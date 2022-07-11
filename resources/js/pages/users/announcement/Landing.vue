<template>
    <div class="container-fluid row">
        <div class="col-lg-7 m-auto">
            <div class="pb-3 mb-3 border-bottom">
                <h1>Announcements</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-4 m-auto" v-for="announcement in announcements" :key="announcement.id">
                    <div class="card px-3">
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