import axios from 'axios'
import * as types from '../mutation-types'
import Form from 'vform'

// state
export const state = {
    loading: false,
    courses: [],
    comments: [],
    course: {},
    courseForm: new Form({
        course_category_id: '',
        title: '',
        description: '',
        video_url: '',
        is_embed: '',
        embed_code: '',
        featured_image: ''
    }),
    commentForm: new Form({
        course_id: '',
        comment: '',
    }),
    file: ''
}

// getters
export const getters = {
    loading: state => state.loading,
    courses: state => state.courses,
    comments: state => state.comments,
    course: state => state.course,
    courseForm: state => state.courseForm,
    commentForm: state => state.commentForm,
}

// mutations
export const mutations = {
    [types.SET_COURSE_FEATURED_IMAGE] (state, data) {
        state.file = data.featured_image;
    },

    [types.FETCH_ALL_COURSES] (state, {data}) {
        state.courses = data        
        state.loading = false
    },

    [types.FETCH_COURSE] (state, {data}) {
        state.course = data
        state.comments = data.comments
        state.loading = false
    },
    [types.SAVE_COURSE] (state, {course}) {
        const index = state.courses.findIndex(hb => hb.id === course.id)
        state.courseForm.reset()

        if (index !== -1) {
            state.courses.splice(index, 1, course)
            state.course = course;
        } else {
            state.courses.unshift(course)
        }

        state.loading = false
    },
    [types.POST_COMMENT] (state, {comment}) {
        const index = state.comments.findIndex(hb => hb.id === comment.id)
        state.commentForm.reset()

        if (index !== -1) {
            state.comments.splice(index, 1, comment)
            state.comment = comment;
        } else {
            state.comments.unshift(comment)
        }

        state.loading = false
    },
    [types.DELETE_COURSE] (state, id) {
        const index = state.courses.findIndex(_course => _course.id === id)
        if (index !== -1) {
            state.courses.splice(index, 1)
        }

        state.course = {}
    },

    [types.DELETE_MY_COMMENT] (state, id) {
        const index = state.comments.findIndex(_course => _course.id === id)
        if (index !== -1) {
            state.comments.splice(index, 1)
        }

        state.comment = {}
    }
}

// actions
export const actions = {

    async fetchCourses ({ commit }) {
        try {
            state.course = {}
            state.loading = true
            
            const { data } = await axios.get(route('course.list'))

            commit(types.FETCH_ALL_COURSES, data)
            
        } catch (error) {
            state.loading = false
            console.log(error.message)
        }
    },

    async fetchCourse ({ commit }, id) {
        try {
            state.loading = true
            
            const { data } = await axios.get(route('course.single', id))

            commit(types.FETCH_COURSE, data)
        } catch (error) {
            state.loading = false
        }
    },
        
    async saveCourse ({ commit }) {
        try {
            state.loading = true

            // convert is_embed into 1 : 0
            let is_embed = state.courseForm.is_embed;
            state.courseForm.is_embed = is_embed ? 1 : 0;
            state.courseForm.featured_image = state.file

            const saveURL = route('course.store')
            const { data } = await (state.courseForm.post(saveURL))
            commit(types.SAVE_COURSE, { course: data.data })
            return data
        } catch (error) {
            state.loading = false
            return state.courseForm.errors
        }
    },

    async postComment ({ commit }, payload) {
        try {
            state.loading = true

            state.commentForm.course_id = payload.course_id;

            const saveURL = route('course_comment.store')
            const { data } = await (state.commentForm.post(saveURL))
            commit(types.POST_COMMENT, { comment: data.data })
            return data
        } catch (error) {
            state.loading = false
            return state.commentForm.errors
        }
    },

    async updateCourse ({ commit }, id) {
        try {
            state.loading = true
                
            if (id) {
                state.courseForm.id = id;
            }

            // convert is_embed into 1 : 0
            let is_embed = state.courseForm.is_embed;
            state.courseForm.is_embed = is_embed ? 1 : 0;
            state.courseForm.featured_image = state.file
            
            const saveURL = route('course.update', id)
            const { data } = await (state.courseForm.put(saveURL))
            return data
        } catch (error) {
            state.loading = false
            return state.courseForm.errors
        }
    },

    async deleteCourse ({ commit }, id) {
        try {
            const { data } = await axios.delete(route('course.delete', id))
            commit(types.DELETE_COURSE, id)
            return data
        } catch (error) {
            state.loading = false
            const { response } = error
            return response.data
        }
    },

    async removeComment ({ commit }, id) {
        try {
            state.loading = true

            const { data } = await axios.delete(route('course_comment.delete', id))
            commit(types.DELETE_MY_COMMENT, id)
            return data
        } catch (error) {
            state.loading = false
            console.log(error)
        }
    },

    async setFeaturedImage({commit}, payload) {
        commit(types.SET_COURSE_FEATURED_IMAGE, payload)
    }
}