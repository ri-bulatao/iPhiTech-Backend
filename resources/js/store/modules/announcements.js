import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
    announcements: [],
    announcement: {}
}

// getters
export const getters = {
    announcements: state => state.announcements,
    announcement: state => state.announcement
}

// mutations
export const mutations = {
    [types.SET_ANNOUNCEMENTS] (state, {announcements}) {
        state.announcements = announcements
    },

    [types.SET_ANNOUNCEMENT] (state, {announcement}) {
        state.announcement = announcement
    }
}

// actions
export const actions = {
    
    createAnnouncement({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.post(route('announcements.store'), payload)
                .then(res => {
                    Cookies.set('intended_url', 'admin.announcements.list')
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    fetchAnnouncements({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(route('announcements.list'), { params: payload })
                .then(res => {
                    let response = res.data
                    commit(types.SET_ANNOUNCEMENTS, {announcements: response.data})
                    resolve(response)
                })
                .catch(err => {
                    reject(err)
                })
        })
    },

    fetchAnnouncement({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(route('announcements.single', { id: payload }))
                .then(res => {
                    let response = res.data
                    commit(types.SET_ANNOUNCEMENT, { announcement: response.data })
                    resolve(response.data)
                })
                .catch(err => reject(err))
        })
    },

    updateAnnouncement({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.put(route('announcements.update', { id: payload.id }), payload.form)
                .then(res => {
                    Cookies.set('intended_url', 'admin.announcements.list')
                    let response = res.data
                    commit(types.SET_ANNOUNCEMENT, { announcement: response.data })
                    resolve(response)
                })
                .catch(err => reject(err))
        })
    },

    postAnnouncement({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.put(route('announcements.post'), payload)
                .then(res => {
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    deleteAnnouncement({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.delete(route('announcements.delete', { id: payload }))
                .then(res => {
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    uploadImage({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.post(route('announcements.upload'), payload)
                .then(res => {
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    }

}