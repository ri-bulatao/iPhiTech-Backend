import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
    leave_applications: [],
    leave_application: {}
}

export const getters = {
    leave_applications: state => state.leave_applications,
    leave_application: state => state.leave_application
}

export const mutations = {
    [types.SET_LEAVE_APPLICATIONS] (state, {applications}) {
        state.leave_applications = applications
    },

    [types.SET_LEAVE_APPLICATION] (state, {application}) {
        state.leave_application = application
    }
}

export const actions = {
    createLeaveApplication({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.post(route('leaves.store'), payload)
                .then(res => resolve(res.data))
                .catch(err => reject(err))
        })
    },

    fetchLeaveApplications({commit, dispatch}) {
        return new Promise((resolve, reject) => {
            axios.get(route('leaves.list'))
                .then(res => {
                    commit(types.SET_LEAVE_APPLICATIONS, { applications: res.data.data })
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    fetchLeaveApplication({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(route('leaves.single', { id: payload.id }))
                .then(res => {
                    commit(types.SET_LEAVE_APPLICATION, { application: res.data.data })
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    updateLeaveApplication({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.put(route('leaves.update', { id: payload.id }), payload)
                .then(res => resolve(res.data))
                .catch(err => reject(err))
        })
    },

    deleteLeaveApplication({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.delete(route('leaves.delete', { id: payload.id }))
                .then(res => resolve(res.data))
                .catch(err => reject(err))
        })
    }

}