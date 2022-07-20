<template>
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-end">
            <router-link :to="{ name: 'admin.course.edit', params: { id: id } }" class="btn btn-primary">Edit Course Category</router-link>
        </div>
        <div class="col-md-12">
            <dl class="row">
                <dt class="col-sm-3">Title</dt>
                <dd class="col-sm-9">{{ course.title }}</dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{ course.description }}</dd>
                
                <dt class="col-sm-3">Embeded youtube video</dt>
                <dd class="col-sm-9">{{ course.is_embed ? "Yes" : "No" }}</dd>
            </dl>
        </div>
        <div class="col-md-12" v-if="!course.is_embed">
            <iframe id="course-video" :src="course.video_url" frameborder="0"></iframe>
        </div>
        <div class="col-md-12" v-else>
            <iframe id="course-video" :src="course.embed_video_url" frameborder="0"></iframe>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

    middleware: 'admin',

    data: () => ({
        id: null,
        embededVideoUrl: ""
    }),

    computed: mapGetters({
        course: 'courses/course'
    }),

    created(){
        this.$store.dispatch('courses/fetchCourse', { id: this.$route.params.id });
        this.id = this.$route.params.id;
    },
}
</script>
<style scoped>
    #course-video {
        width: 100%;
        height: calc(100vh - 50%);
    }
</style>