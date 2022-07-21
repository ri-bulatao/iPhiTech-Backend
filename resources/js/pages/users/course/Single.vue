<template>
    <div class="container-fluid row custom-container">
        <div class="col-lg-12">
            <div class="pb-3 mb-3">
                <img :src="course.featured_image" class="img-fluid course-img" :alt="course.title">
                <h1>{{ course.title }}</h1>
                <p>{{ course.course_category.title }} 
                    <span class="badge bg-danger" v-if="user_course">Subscribed</span>
                    <span class="badge bg-success" v-else>Available</span>
                </p>
                <!-- <p class="mt-4">{{ course.description }}</p> -->
                <div class="py-2" v-html="course.description"></div>
                <button class="btn btn-primary" @click="subscribed" v-if="!user_course">Subscribe Now</button>
            </div>
            <hr>
            <div class="pt-3">
                <div class="row">
                    <div class="col-md-7 pb-4">
                        <h1 class="text-dark">Comments</h1>
                        <div class="comment mt-4 text-justify float-left" v-for="comment in course.comments" :key="comment.id">
                            <img :src="comment.user.photo_url" alt="" class="rounded-circle" width="40" height="40">
                            <h4 class="">{{ comment.user.full_name }}</h4>
                            <span>- {{ comment.created_at | moment("MMMM Do YYYY") }}</span>
                            <a @click="() => deleteReady(comment.id)" href="javascript:void(0)" class="btn btn-danger btn-sm float-right" v-if="comment.user.id == user.id"><fa icon="trash" /></a>
                            <br>
                            <p>{{ comment.comment }}</p>
                        </div>
                        <p v-if="course.comments.length <= 0">No available comments</p>
                    </div>
                    <div class="col-md-5 mt-4">
                        <form id="algin-form" @submit.prevent="postComment" @keydown="commentForm.onKeydown($event)">
                            <div class="form-group">
                                <h4 class="text-light">Leave a comment</h4>
                                <label for="message">Message</label>
                                <textarea name="msg" v-model="commentForm.comment" id="msg" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group d-flex justify-content-end mt-2">
                                <!-- Submit Button -->
                                <v-button :loading="commentForm.busy" class="btn btn-primary btn-sm">
                                    Post Comment
                                </v-button>
                            </div>
                        </form>
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

    name: 'courses-landing',

    middleware: 'auth',

    data: () => ({
        id: null,
        user_course: null
    }),

    computed: mapGetters({
        course: 'courses/course',
        commentForm: 'courses/commentForm',
        user: 'auth/user',
    }),

    mounted() {
        this.$store.dispatch('courses/fetchCourse', { id: this.$route.params.id }).then(() => {
            this.user_course = this.course.user_course;
        });

        this.id = this.$route.params.id;
    },

    metaInfo () {
        return { title: this.$t('Viewing Course') }
    },

    methods: {
        subscribed() {
            let payload = {
                course_id: this.course.id
            }

            this.$store.dispatch('user-course/subscribeCourse', payload).then(()=>{
                this.user_course = true;
                ToastSuccess('Successfully subscribed', 'You have been now subscribed to' + this.course.title)
            });
        },

        postComment() {
            let payload = {
                course_id: this.course.id
            }

            this.$store.dispatch('courses/postComment', payload).then(()=>{
                ToastSuccess('', 'Comment has been posted')
            });
        },

        deleteReady(id) {
            AlertQuestion('Are you sure to delete ?', 'There is no undo for this action', true, 'Yes, Delete!')
                .then(res => {
                    this.deleteComment(id)
                })
        },

        deleteComment(id) {
            this.$store.dispatch('courses/removeComment', id)
                .then(res => {
                    ToastSuccess('Deleted!', res.message)
                })
                .catch(err => {
                    ToastError()
                })
        }
    }
}
</script>

<style scoped>
    .course-img {
        height: 400px;
        width: 100%;
        object-fit: cover;
    }

    .darker{
        border: 1px solid #ecb21f;
        background-color: black;
        float: right;
        border-radius: 5px;
        padding-left: 40px;
        padding-right: 30px;
        padding-top: 10px;
    }

    .comment{
        border: 1px solid rgba(16, 46, 46, 1);
        background-color: rgb(33 37 41);
        float: left;
        border-radius: 5px;
        padding-left: 40px;
        padding-right: 30px;
        padding-top: 10px;
        width: 90%;
    }
    .comment h4,.comment span,.darker h4,.darker span{
        display: inline;
    }

    .comment p,.comment span,.darker p,.darker span{
        color: rgb(184, 183, 183);
    }

    h1, .comment h4{
        color: white;
        font-weight: bold;
    }
    label{
        color: rgb(212, 208, 208);
    }

    #align-form{
        margin-top: 20px;
    }
    .form-group p a{
        color: white;
    }

    #checkbx{
        background-color: black;
    }

    #darker img{
        margin-right: 15px;
        position: static;
    }

    .form-group input,.form-group textarea{
        background-color: rgb(235, 235, 235);
        border: 1px solid rgba(16, 46, 46, 1);
        border-radius: 12px;
    }

    form{
        border: 1px solid rgba(16, 46, 46, 1);
        background-color: rgb(33 37 41);
        border-radius: 5px;
        padding: 20px;
    }

    .comment img {
        margin-right: 0.5rem;
    }

    .comment p {
        margin-top: 0.7rem;
    }
</style>