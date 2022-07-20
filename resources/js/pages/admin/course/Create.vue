<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Add Course
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="saveCourse" @keydown="courseForm.onKeydown($event)">
                            <!-- Title -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('title') }}</label>
                                <div class="col-md-12">
                                    <input v-model="courseForm.title" :class="{ 'is-invalid': courseForm.errors.has('title') }" class="form-control" type="text" name="title">
                                    <has-error :form="courseForm" field="title" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('description') }}</label>
                                <div class="col-md-12">
                                    <textarea v-model="courseForm.description" name="description" id="description" rows="3" class="form-control" :class="{ 'is-invalid': courseForm.errors.has('description') }" placeholder=""></textarea>
                                    <has-error :form="courseForm" field="description" />
                                </div>
                            </div>
                            
                            <!-- Course Category -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('Course Category') }}</label>
                                <div class="col-md-12">
                                    <select v-model="courseForm.course_category_id" name="course_category_id" id="course_category_id" class="form-control">
                                        <option v-for="course_category in course_categories" :key="course_category.id" :value="course_category.id">{{ course_category.title }}</option>
                                    </select>
                                    <has-error :form="courseForm" field="course-category" />
                                </div>
                            </div>

                            <!-- Is Embed -->
                            <div class="mb-3 row">
                                <div class="col-md-12">
                                    <input
                                        id="checkbox"
                                        type="checkbox"
                                        name="is_embed"
                                        v-model="courseForm.is_embed"
                                        @change="videoChange"
                                    />
                                    <label for="checkbox">Embed Youtube Video</label>
                                </div>
                            </div>

                            <!-- Video URL -->
                            <div class="mb-3 row" v-if = "!isVideoEmbed">
                                <label class="col-md-12">{{ $t('Video URL') }}</label>
                                <div class="col-md-12">
                                    <input v-model="courseForm.video_url" :class="{ 'is-invalid': courseForm.errors.has('video_url') }" class="form-control" type="text" name="video_url">
                                    <has-error :form="courseForm" field="video_url" />
                                </div>
                            </div>

                            <!-- Youtube Video ID -->
                            <div class="mb-3 row" v-else>
                                <label class="col-md-12">{{ $t('Youtube Video ID') }}</label>
                                <div class="col-md-12">
                                    <input v-model="courseForm.embed_code" :class="{ 'is-invalid': courseForm.errors.has('embed_code') }" class="form-control" type="text" name="embed_code">
                                    <has-error :form="courseForm" field="embed_code" />
                                </div>
                            </div>

                            <!-- Featured Image -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('Featured Image') }}</label>
                                <div class="col-md-12">
                                    <input type="file" class="form-control" name="book" @change="courseFeatureImageUpload">
                                    <has-error :form="courseForm" field="featured_image" />
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <v-button :loading="courseForm.busy" class="btn btn-primary btn-sm" @click="saveCourse()">
                                Submit
                            </v-button>

                            <router-link 
                                class="btn btn-secondary btn-sm" 
                                :to="{ name: 'admin.course.list' }"
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
        isVideoEmbed: false,
        file: ''
    }),

    computed: mapGetters({
        course_categories: 'course-categories/course_categories',
        courseForm: "courses/courseForm",
    }),

    created(){
        this.courseForm.reset()
    },

    methods: {
        saveCourse() {
            this.$store.dispatch('courses/saveCourse')
                .then(({success, message}) => {
                    if (success) {
                        ToastSuccess('Course Saved', message)
                        this.$router.push({ name: 'admin.course.list' })
                    }
                })
                .catch(err => {
                    ToastError()
                })
        },
        videoChange() {
            this.isVideoEmbed = !this.isVideoEmbed
        },
        courseFeatureImageUpload(event) {
            let payload = {
                featured_image: event.target.files[0]
            }

            this.$store.dispatch('courses/setFeaturedImage', payload)
        },
    }
}
</script>