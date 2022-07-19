<template>
    <div class="row">
        <div class="col-lg-10 m-auto d-flex justify-content-between align-items-center">
            <h1>{{ course_category.title }}</h1>
            <router-link :to="{ name: 'admin.course.category.edit', params: { id: id } }" class="btn btn-primary">Edit Course Category</router-link>
        </div>
        <!-- <div class="col-lg-10 m-auto">
            <div class="py-3">
                <h1>{{ course_category.title }}</h1>
            </div>
        </div> -->
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

    middleware: 'admin',

    data: () => ({
        id: null
    }),

    computed: mapGetters({
        course_category: 'course-categories/course_category'
    }),

    created(){
        this.$store.dispatch('course-categories/fetchCourseCategory', { id: this.$route.params.id });
        this.id = this.$route.params.id;
    },
}
</script>