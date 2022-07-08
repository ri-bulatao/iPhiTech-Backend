<template>
    <div class="row">
        <div class="col-lg-10 m-auto d-flex justify-content-between align-items-center">
            <div>
                <small>{{ announcement.status }}</small>
            </div>
            
            <router-link :to="{ name: 'admin.announcements.edit', params: { id: id } }" class="btn btn-primary">Edit Announcement</router-link>
        </div>
        <div class="col-lg-10 m-auto">
            <div class="py-3">
                <h1>{{ announcement.title }}</h1>
            </div>
            <div class="py-2">
                <p>{{ announcement.excerpt }}</p>
            </div>
            <div class="py-2 overflow-hidden" v-html="announcement.content"></div>
        </div>
        <div class="col-lg-10 m-auto pt-5 d-flex justify-content-end">
            <button class="btn btn-success">Post Announcement</button>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

    data: () => ({
        id: ''
    }),

    computed: mapGetters({
        announcement: 'announcements/announcement'
    }),

    mounted() {
        this.id = this.$route.params.id
        this.$store.dispatch('announcements/fetchAnnouncement', this.id)
            .then(res => console.log(res))
            .catch(err => console.log(err))
    }
}
</script>