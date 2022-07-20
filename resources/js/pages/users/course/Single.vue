<template>
    <div class="container-fluid row custom-container">
        <div class="col-lg-12">
            <div class="pb-3 mb-3">
                <img :src="course.featured_image" class="img-fluid course-img" :alt="course.title">
                <h1>{{ course.title }}</h1>
                <p>{{ course.course_category.title }} 
                    <span class="badge bg-danger" v-if="user_course">Subscribed</span>
                    <span class="badge bg-success" v-else>Available</span>
                </p>
                <p class="mt-4">{{ course.description }}</p>
                <button class="btn btn-primary" @click="subscribed" v-if="!user_course">Subscribe Now</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { ToastSuccess, ToastError } from '~/config/alerts'

export default {

    name: 'courses-landing',

    middleware: 'auth',

    data: () => ({
        id: null,
        user_course: null
    }),

    computed: mapGetters({
        course: 'courses/course'
    }),

    mounted() {
        this.$store.dispatch('courses/fetchCourse', { id: this.$route.params.id }).then(() => {
            this.user_course = this.course.user_course;
        });

        this.id = this.$route.params.id;
    },

    metaInfo () {
        return { title: this.$t('Viewing Course') }
    },

    methods: {
        subscribed() {
            let payload = {
                course_id: this.course.id
            }

            this.$store.dispatch('user-course/subscribeCourse', payload).then(()=>{
                this.user_course = true;
                ToastSuccess('Successfully subscribed', 'You have been now subscribed to' + this.course.title)
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
</style>