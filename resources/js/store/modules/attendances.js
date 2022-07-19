import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

export const state = {
    attendances: [],
    attendnaceToday: {}
}

export const getters = {
    attendances: state => state.attendances,
    attendanceToday: state => state.attendanceToday
}

export const mutations = {
    [types.SET_ATTENDANCES] (state, {attendances}) {
        state.attendances = attendances
    },

    [types.SET_ATTENDANCE_TODAY] (state, {attendance}) {
        state.attendanceToday = attendance
    }
}

export const actions = {
    fetchAttendanceToday({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(route('attendances.today'), { params: { user_id: payload.user_id } })
                .then(res => {
                    commit(types.SET_ATTENDANCE_TODAY, {attendance: res.data.data})
                    resolve(res.data.data)
                })
                .catch(err => reject(err))
        })
    },

    fetchAttendances({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(route('attendances.list'), { params: { id: payload.user_id } })
                .then(res => {
                    commit(types.SET_ATTENDANCES, {attendances: res.data.data})
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    timein({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.post(route('attendances.time_in'), payload)
                .then(res => {
                    console.log(res)
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    timeout({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.put(route('attendances.time_out'), payload)
                .then(res => {
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    },

    fetchEmployeeAttendances({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(route('attendances.employee'), { params: payload })
                .then(res => {
                    commit(types.SET_ATTENDANCES, { attendances: res.data.data })
                    resolve(res.data)
                })
                .catch(err => reject(err))
        })
    }
}