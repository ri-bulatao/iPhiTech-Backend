<template>
    <div class="container-fluid row custom-container">
        <div class="col-lg-12">
            <div class="pb-3 mb-3">
                <img :src="course.featured_image" class="img-fluid course-img" :alt="course.title">
                <h1>{{ course.title }}</h1>
                <p>Course</p>
                <p class="mt-4">{{ course.description }}</p>
                <button class="btn btn-primary" @click="subscribed">Subscribe</button>
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
    }),

    computed: mapGetters({
        course: 'courses/course'
    }),

    mounted() {
        this.$store.dispatch('courses/fetchCourse', { id: this.$route.params.id });
        this.id = this.$route.params.id;
    },

    metaInfo () {
        return { title: this.$t('Viewing Course') }
    },

    methods: {
        subscribed() {
            console.log(this.id)
            console.log(this.course.id)
        }
    }
}
</script>

<style scoped>
    .course-img {
        height: 400px;
        width: 100%;
        object-fit: cover;
        transform: scale(0.7);
    }
</style>