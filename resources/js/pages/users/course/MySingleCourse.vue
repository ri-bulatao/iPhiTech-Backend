<template>
    <div class="container-fluid row custom-container">
        <div class="col-lg-12">
            <div class="pb-3 mb-3">
                <img :src="course.course.featured_image" class="img-fluid course-img" :alt="course.course.title">
                <h1>{{ course.course.title }}</h1>
                <p>{{ course.course.course_category.title }} 
                    <span class="badge bg-secondary" v-if="status == 'Ready'">{{ status }}</span>
                    <span class="badge bg-warning" v-else-if="status == 'Inprogress'">{{ status }}</span>
                    <span class="badge bg-success" v-else-if="status == 'Completed'">{{ status }}</span>
                </p>
                <p class="mt-4">{{ course.course.description }}</p>
                <button class="btn btn-primary" @click="startNow" v-if="status == 'Ready'">Start Now</button>
            </div>
        </div>
        <div class="row" v-if="status == 'Inprogress' || status == 'Completed'">
            <div class="col-md-12" v-if="!course.course.is_embed">
                <iframe id="course-video" :src="course.course.video_url" frameborder="0"></iframe>
            </div>
            <div class="col-md-12" v-else>
                <iframe id="course-video" :src="course.course.embed_video_url" frameborder="0"></iframe>
            </div>
            <!-- <div class="quick-exam">
                <h4>Quick Test</h4>
            </div> -->
            <div class="col-md-12" v-if="status == 'Inprogress'">
                <button class="btn btn-primary" @click="markAsComplete" v-if="status == 'Inprogress'">Mark as Complete</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

    name: 'courses-landing',

    middleware: 'auth',

    data: () => ({
        id: null,
        status: "Ready",
    }),

    computed: mapGetters({
        course: 'user-course/course',
        loading: 'user-course/loading',
    }),

    mounted() {
        this.$store.dispatch('user-course/fetchCourse', { id: this.$route.params.id }).then(({data}) => {
            this.status = data.status
        });
        this.id = this.$route.params.id;
        
    },

    metaInfo () {
        return { title: this.$t('Viewing Course') }
    },

    methods: {
        startNow() {
            const payload = {
                course_id: this.id,
                status: "Inprogress"
            }

            this.$store.dispatch('user-course/processCourse', payload).then(({data}) => {
                this.status = "Inprogress"
            });
            
        },
        markAsComplete() {
            const payload = {
                course_id: this.id,
                status: "Completed"
            }

            this.$store.dispatch('user-course/processCourse', payload).then(({data}) => {
                this.status = "Completed"
            });
        }
    }
}
</script>

<style scoped>
    .course-img {
        height: 400px;
        width: 100%;
        object-fit: cover;
    }

    #course-video {
        width: 100%;
        height: 40rem;
        /* height: calc(100vh - 50%); */
    }
</style>