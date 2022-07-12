import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

export const state = {
    notifications: [],
    unreadNotifications: []
}

export const getters = {
    notifications: state => state.notifications,
    unreadNotifications: state => state.unreadNotifications
}

export const mutations = {
    [types.SET_NOTIFICATIONS] (state, {notifications}) {
        state.notifications = notifications
    },

    [types.SET_UNREAD_NOTIFICATIONS] (state, {unreadNotifications}) {
        state.unreadNotifications = unreadNotifications
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

    fetchUnreadNotifications({commit, dispatch}) {
        return new Promise((resolve, reject) => {
            axios.get(route('notifications.unread'), {}, { headers: { Authorization: 'Bearer ' + Cookies.get('token') } })
                .then(res => {
                    commit(types.SET_UNREAD_NOTIFICATIONS, { unreadNotifications: res.data.data })
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