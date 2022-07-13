<template>
    <div class="container-fluid row">
        <div class="col-lg-7 m-auto">
            <div class="mb-3 border-bottom">
                <h1>Announcement</h1>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">{{ announcement.title }}</h2>
                            <small class="card-subtitle text-muted">{{ announcement.pretty_created }}</small>
                        </div>
                    </div>
                    <div class="mt-4" v-html="announcement.content"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Swal from 'sweetalert2'

export default {

    middleware: 'auth',

    data: () => ({
        id: ''
    }),

    computed: mapGetters({
        announcement: 'announcements/announcement'
    }),
    
    mounted() {
        this.id = this.$route.params.id

        this.$store.dispatch('announcements/fetchAnnouncement', this.id)
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops',
                    text: 'Something went wrong'
                })
            })
    }
}

</script>