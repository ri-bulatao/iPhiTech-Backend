import axios from 'axios'
import * as types from '../mutation-types'
import Form from 'vform'

// state
export const state = {
    loading: false,
    courseForm: new Form({
        course_id: '',
        status: '',
        grade_status: ''
    })
}

// getters
export const getters = {
    loading: state => state.loading,
    courses: state => state.courses,
    course: state => state.course,
    courseForm: state => state.courseForm,
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
    [types.DELETE_COURSE] (state, id) {
        const index = state.courses.findIndex(_course => _course.id === id)
        if (index !== -1) {
            state.courses.splice(index, 1)
        }

        state.course = {}
    }
}

// actions
export const actions = {

    async fetchCourses ({ commit }) {
        try {
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

    async setFeaturedImage({commit}, payload) {
        commit(types.SET_COURSE_FEATURED_IMAGE, payload)
    }
}