<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Add Course Category
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="saveCourseCategory" @keydown="courseCategoryForm.onKeydown($event)">
                            <!-- Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('title') }}</label>
                                <div class="col-md-12">
                                    <input v-model="courseCategoryForm.title" :class="{ 'is-invalid': courseCategoryForm.errors.has('title') }" class="form-control" type="text" name="title">
                                    <has-error :form="courseCategoryForm" field="title" />
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <v-button :loading="courseCategoryForm.busy" class="btn btn-primary btn-sm" @click="saveCourseCategory()">
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
        position: 'positions/position',
        courseCategoryForm: "course-categories/courseCategoryForm",
    }),

    created(){
        this.courseCategoryForm.reset()
    },

    methods: {
        saveCourseCategory() {
            this.$store.dispatch('course-categories/saveCourseCategory')
                .then(({success, message}) => {
                    if (success) {
                        ToastSuccess('Course Category Saved', message)
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