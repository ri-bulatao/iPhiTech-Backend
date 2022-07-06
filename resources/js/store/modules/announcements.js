import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
    
}

// getters
export const getters = {

}

// mutations
export const mutations = {

}

// actions
export const actions = {
    
    async fetchAnnouncements({commit, dispatch}, payload) {
        try {
            const res = await axios.get('/api/announcements/test', null, {
                Accept: 'application/json',
                ContentType: 'application/json'
            })

            console.log(res)
        }
        catch(error) {
            console.log(error)
        }
    }

}