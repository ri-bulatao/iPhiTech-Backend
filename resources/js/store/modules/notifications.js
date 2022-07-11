import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

export const state = {
    notifications: []
}

export const getters = {
    notifications: state => state.notifications
}

export const mutations = {
    [types.SET_NOTIFICATIONS] (state, {notifications}) {
        state.notifications = notifications
    }
}

export const actions = {
    fetchNotifications({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(route('notifications.list'), { params: payload }, { headers: { Authorization: 'Bearer ' + Cookies.get('token') } })
                .then(res => {
                    let notifications = res.data.data.notifications
                    commit(types.SET_NOTIFICATIONS, {notifications: notifications})
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    updateNotification({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.put(route('notifications.update', { id: payload.id }), payload)
                .then(res => resolve(res.data))
                .catch(err => reject(err))
        })
    },

    deleteNotification({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.delete(route('notifications.delete', {id: payload}))
                .then(res => resolve(res.data))
                .catch(err => reject(err))
        })
    }
}