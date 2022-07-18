import axios from 'axios'
import * as types from '../mutation-types'
import Form from 'vform'

// state
export const state = {
    loading: false,
    course_categories: [],
    course_category: {},
    courseCategoryForm: new Form({
        title: '',
    })
}

// getters
export const getters = {
    loading: state => state.loading,
    course_categories: state => state.course_categories,
    course_category: state => state.course_category,
    courseCategoryForm: state => state.courseCategoryForm,
}

// mutations
export const mutations = {

    [types.SET_COURSE_CATEGORY] (state, data) {
        state.courseCategoryForm.book = data.book
    },

    [types.FETCH_ALL_COURSE_CATEGORIES] (state, {data}) {
        state.course_categories = data        
        state.loading = false
    },

    [types.FETCH_COURSE_CATEGORY] (state, {data}) {
        state.course_category = data
        state.loading = false
    },

    [types.SAVE_COURSE_CATEGORY] (state, {course_category}) {
        const index = state.course_categories.findIndex(hb => hb.id === course_category.id)
        state.courseCategoryForm.reset()

        if (index !== -1) {
            state.course_categories.splice(index, 1, course_category)
            state.course_category = course_category;
        } else {
            state.course_categories.unshift(course_category)
        }

        state.loading = false
    },
    [types.DELETE_COURSE_CATEGORY] (state, id) {
        const index = state.course_categories.findIndex(_handbook => _handbook.id === id)
        if (index !== -1) {
            state.course_categories.splice(index, 1)
        }

        state.course_category = {}
    }
}

// actions
export const actions = {

    async fetchCourseCategories ({ commit }) {
        try {
            state.loading = true
            
            const { data } = await axios.get(route('course_category.list'))

            commit(types.FETCH_ALL_COURSE_CATEGORIES, data)
            
        } catch (error) {
            state.loading = false
            console.log(error.message)
        }
    },

    async fetchCourseCategory ({ commit }, id) {
        try {
            state.loading = true
            
            const { data } = await axios.get(route('course_category.single', id))

            commit(types.FETCH_COURSE_CATEGORY, data)
        } catch (error) {
            state.loading = false
        }
    },
        
    async saveCourseCategory ({ commit }) {
        try {
            state.loading = true

            const saveURL = route('course_category.store')
            const { data } = await (state.courseCategoryForm.post(saveURL))
            commit(types.SAVE_COURSE_CATEGORY, { course_category: data.data })
            return data
        } catch (error) {
            state.loading = false
            return state.courseCategoryForm.errors
        }
    },

    async updateCourseCategory ({ commit }, id) {
        try {
            state.loading = true
                
            if (id) {
                state.courseCategoryForm.id = id;
            }

            const saveURL = route('course_category.update', id)
            const { data } = await (state.courseCategoryForm.put(saveURL))
            return data
        } catch (error) {
            state.loading = false
            return state.courseCategoryForm.errors
        }
    },

    async deleteCourseCategory ({ commit }, id) {
        try {
            const { data } = await axios.delete(route('course_category.delete', id))
            commit(types.DELETE_COURSE_CATEGORY, id)
            return data
        } catch (error) {
            state.loading = false
            const { response } = error
            return response.data
        }
    },
}