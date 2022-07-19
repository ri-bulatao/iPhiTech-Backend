<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Add Course Category
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="updateCourseCategory" @keydown="courseCategoryForm.onKeydown($event)">
                            <!-- Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('title') }}</label>
                                <div class="col-md-12">
                                    <input v-model="courseCategoryForm.title" :class="{ 'is-invalid': courseCategoryForm.errors.has('title') }" class="form-control" type="text" name="title">
                                    <has-error :form="courseCategoryForm" field="title" />
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <v-button :loading="courseCategoryForm.busy" class="btn btn-primary btn-sm" @click="updateCourseCategory()">
                                Submit
                            </v-button>

                            <router-link 
                                class="btn btn-secondary btn-sm" 
                                :to="{ name: 'admin.course.category.list' }"
                            > Back to List </router-link>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { ToastSuccess, ToastError } from '~/config/alerts'

export default {

    middleware: 'admin',

    data: () => ({
    }),

    computed: mapGetters({
        course_category: 'course-categories/course_category',
        courseCategoryForm: "course-categories/courseCategoryForm",
    }),

    created(){
        this.$store.dispatch('course-categories/fetchCourseCategory', { id: this.$route.params.id })
        .then(()=>{
            this.courseCategoryForm.keys().forEach(key => {
                this.courseCategoryForm[key] = this.course_category[key]
            })
        });
    },

    methods: {
        updateCourseCategory() {
            this.$store.dispatch('course-categories/updateCourseCategory', { id: this.$route.params.id })
                .then(({success, message}) => {
                    if (success) {
                        ToastSuccess('Course Category Updated', message)
                        this.$store.dispatch('course-categories/fetchCourseCategories')
                        this.$router.push({ name: 'admin.course.category.list' })
                    }
                })
                .catch(err => {
                    ToastError()
                })
        },
    }
}
</script>