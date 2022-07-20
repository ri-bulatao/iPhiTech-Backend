import axios from 'axios'
import * as types from '../mutation-types'
import Form from 'vform'

// state
export const state = {
    loading: false,
    courses: [],
    course: {},
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
    [types.SET_LOADING] (state, status) {
        state.loading = status
    },

    [types.SUBSCRIBE_COURSE] (state, data) {
        state.file = data.featured_image;
    },

    [types.FETCH_USER_COURSES] (state, {data}) {
        state.courses = data        
        state.loading = false
    },
    
    [types.FETCH_MY_COURSE] (state, {data}) {
        state.course = data
        state.loading = false
    },
}

// actions
export const actions = {
    async fetchCourses ({ commit }) {
        try {
            state.loading = true
            
            const { data } = await axios.get(route('user_course.list'))

            commit(types.FETCH_USER_COURSES, data)
            
        } catch (error) {
            state.loading = false
            console.log(error.message)
        }
    },

    async fetchCourse ({ commit }, { id }) {
        try {
            state.loading = true
            
            const { data } = await axios.get(route('user_course.single', id))
            
            commit(types.FETCH_MY_COURSE, data)

            return data;
        } catch (error) {
            state.loading = false
        }
    },

    async subscribeCourse ({ commit }, payload) {
        try {
            state.loading = true

            state.courseForm.course_id      = payload.course_id;
            state.courseForm.status         = "Ready";

            const saveURL = route('user_course.subscribe')
            const { data } = await (state.courseForm.post(saveURL))
            commit(types.SUBSCRIBE_COURSE, { course: data.data })
            return data
        } catch (error) {
            state.loading = false
            return state.courseForm.errors
        }
    },

    async processCourse ({ commit }, payload) {
        try {
            state.loading = true

            state.courseForm.course_id      = payload.course_id;
            state.courseForm.status         = payload.status;

            const { data } = await (state.courseForm.put(route('user_course.process')))

            commit(types.FETCH_MY_COURSE, data)
            return data
        } catch (error) {
            state.loading = false
            return state.courseForm.errors
        }
    },

    async setLoading ({ commit }, status) {
        commit(types.SET_LOADING, status)
    }
}