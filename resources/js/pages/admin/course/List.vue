<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex justify-content-end mb-3">
                    <router-link class="btn btn-success" :to="{ name: 'admin.course.create' }">Create Category</router-link>
                </div>
                <div class="card">
                    <div class="card-header">
                        List of Courses
                    </div>
                    <div class="card-body">
                        <table class="table table-striped caption-top">
                            <thead>
                                <tr>
                                    <td> <strong>#</strong> </td>
                                    <td> <strong>Title</strong> </td>
                                    <td> <strong>Category</strong> </td>
                                    <td> <strong>Video URL</strong> </td>
                                    <td> <strong>Date</strong> </td>
                                    <td> <strong>Actions</strong> </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(course, index) in courses" :key="course.id">
                                    <td class="col-md-1">{{ index + 1 }}</td>  
                                    <td>{{ course.title }}</td>
                                    <td>{{ course.course_category.title }}</td>
                                    <td>{{ course.video_url }}</td>
                                    <td>{{ course.created_at | moment("dddd, MMMM Do YYYY") }}</td>
                                    <td class="col-md-2">
                                        <router-link 
                                            class="btn btn-primary btn-sm" 
                                            :to="{ name: 'admin.course.single', params: {id: course.id} }"
                                        > View </router-link>
                                        <router-link :to="{ name: 'admin.course.edit', params: { id: course.id } }" class="btn btn-warning btn-sm">Edit</router-link>
                                        <a @click="() => deleteReady(course.id)" href="javascript:void(0)" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                <tr class="no-data">
                                    <td colspan="6" class="text-center">No data available in table</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import { ToastSuccess, ToastError, AlertQuestion } from '~/config/alerts'

export default {
    name: 'admin-course',
    middleware: 'admin',
    computed: mapGetters({
        courses: 'courses/courses'
    }),

    methods: {
        deleteReady(id) {
            AlertQuestion('Are you sure to delete ?', 'There is no undo for this action', true, 'Yes, Delete!')
                .then(res => {
                    this.delete(id)
                })
        },
        delete(id) {
            this.$store.dispatch('courses/deleteCourse', id)
                .then(res => {
                    ToastSuccess('Deleted!', res.message)
                    this.$store.dispatch('courses/fetchCourses')
                })
                .catch(err => {
                    ToastError()
                })
        }
    }
}

</script>