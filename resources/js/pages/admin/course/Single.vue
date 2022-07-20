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

                <dt class="col-sm-3">Video URL</dt>
                <dd class="col-sm-9">{{ course.video_url }}</dd>

                <dt class="col-sm-3">Is Embed</dt>
                <dd class="col-sm-9">{{ course.is_embed ? "Yes" : "No" }}</dd>

                <dt class="col-sm-3">Embed Code</dt>
                <dd class="col-sm-9">{{ course.embed_code }}</dd>

                <dt class="col-sm-3">Featured Image</dt>
                <dd class="col-sm-9">{{ course.featured_image }}</dd>
            </dl>
        </div>
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
        course: 'courses/course'
    }),

    created(){
        this.$store.dispatch('courses/fetchCourse', { id: this.$route.params.id });
        this.id = this.$route.params.id;
    },
}
</script>