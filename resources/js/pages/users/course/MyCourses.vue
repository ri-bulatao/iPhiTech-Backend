<template>
    <div class="container-fluid row custom-container">
        <div class="col-lg-12">
            <div class="pb-3 mb-3 border-bottom">
                <h1>My Courses</h1>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-4" v-for="item in courses" :key="item.id">
                    <router-link :to="{ name: 'my-course.single', params: { id: item.id } }" class="card-link text-dark">
                        <div class="card shadow rounded">
                            <img :src="item.course.featured_image" class="card-img-top course-img" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ item.course.title }}</h5>
                                <small>{{ item.course.course_category.title }} 
                                    <span class="badge bg-secondary" v-if="item.status == 'Ready'">{{ item.status }}</span>
                                    <span class="badge bg-warning" v-else-if="item.status == 'Inprogress'">{{ item.status }}</span>
                                    <span class="badge bg-success" v-else-if="item.status == 'Completed'">{{ item.status }}</span>
                                </small>
                                <p class="pt-4 card-text elips-text">{{ item.course.description }}</p>
                            </div>
                        </div>
                    </router-link>
                </div>
                <div class="col-md-12" v-if="courses.length <= 0">
                    <p>You don't have subscription yet.</p>
                    <router-link :to="{ name: 'courses' }" class="btn btn-success">Choose your Course</router-link>
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
        courses: 'user-course/courses'
    }),

    mounted() {
        this.$store.dispatch('user-course/fetchCourses')
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