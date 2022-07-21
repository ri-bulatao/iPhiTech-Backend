<template>
    <div class="container-fluid row custom-container">
        <div class="col-lg-12">
            <div class="pb-3 mb-3 border-bottom">
                <h1>Courses</h1>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-4" v-for="course in courses" :key="course.id">
                    <router-link :to="{ name: 'courses.single', params: { id: course.id } }" class="card-link text-dark">
                        <div class="card shadow rounded">
                            <img :src="course.featured_image" class="card-img-top course-img" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ course.title }}</h5>
                                <small>{{ course.course_category.title }} 
                                    <span class="badge bg-success" v-if="!course.user_course">Availabe</span>
                                    <span class="badge bg-danger" v-else>Subscribed</span>
                                </small>
                                <p class="pt-4 card-text elips-text">{{ course.description }}</p>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

    name: 'courses-landing',

    middleware: 'auth',

    computed: mapGetters({
        courses: 'courses/courses'
    }),

    mounted() {
        this.$store.dispatch('courses/fetchCourses')
    },

    metaInfo () {
        return { title: this.$t('List of Courses') }
    },
}
</script>

<style scoped>
    .course-img {
        height: 220px;
        object-fit: cover;
    }

    .elips-text {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }

    .card-text.elips-text {
        min-height: 96px;
    }

    .card-body {
        height: 215px;
    }
</style>