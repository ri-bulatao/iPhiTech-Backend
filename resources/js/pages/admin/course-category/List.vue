<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex justify-content-end mb-3">
                    <router-link class="btn btn-success" :to="{ name: 'admin.course.category.create' }">Create Category</router-link>
                </div>
                <div class="card">
                    <div class="card-header">
                        List of Course Category
                    </div>
                    <div class="card-body">
                        <table class="table table-striped caption-top">
                            <thead>
                                <tr>
                                    <td> <strong>#</strong> </td>
                                    <td> <strong>Title</strong> </td>
                                    <td> <strong>Actions</strong> </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(course_category, index) in course_categories" :key="course_category.id">
                                    <td class="col-md-1">{{ index + 1 }}</td>  
                                    <td>{{ course_category.title }}</td>
                                    <td class="col-md-2">
                                        <router-link 
                                            class="btn btn-primary btn-sm" 
                                            :to="{ name: 'admin.course.category.single', params: {id: course_category.id} }"
                                        > View </router-link>
                                        <router-link :to="{ name: 'admin.course.category.edit', params: { id: course_category.id } }" class="btn btn-warning btn-sm">Edit</router-link>
                                        <a @click="() => deleteReady(course_category.id)" href="javascript:void(0)" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
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
    name: 'admin-course-category',
    middleware: 'admin',
    computed: mapGetters({
        course_categories: 'course-categories/course_categories'
    }),

    methods: {
        deleteReady(id) {
            AlertQuestion('Are you sure to delete ?', 'There is no undo for this action', true, 'Yes, Delete!')
                .then(res => {
                    this.delete(id)
                })
        },
        delete(id) {
            this.$store.dispatch('course-categories/deleteCourseCategory', id)
                .then(res => {
                    if(res.success){
                        ToastSuccess('Deleted!', res.message)
                        this.$store.dispatch('course-categories/fetchCourseCategories')
                    }else{
                        ToastError("Warning!", "This category attached one of the courses.")
                    }
                    
                })
                .catch(err => {
                    ToastError()
                })
        }
    }
}

</script>