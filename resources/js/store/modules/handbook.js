import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
    loading: false,
    handbooks: [],
    handbook: {},
    handbookForm: {
        version_name: '',
    },
    handbookFormRules: {
        version_name: [
            { required: true, message: 'Please input version name', trigger: 'blur' }
        ]
    }
}

// getters
export const getters = {
    loading: state => state.loading,
    handbooks: state => state.handbooks,
    handbook: state => state.handbook,
    handbookForm: state => state.handbookForm,
    handbookFormRules: state => state.handbookFormRules,
}

// mutations
export const mutations = {
    [types.FETCH_ALL_HANDBOOKS] (state, {data}) {
        state.handbooks = data        
        state.loading = false
    },

    [types.FETCH_HANDBOOK] (state, {handbook}) {
        state.handbook = handbook
        
        state.loading = false
    },

    [types.SAVE_HANDBOOK] (state, {handbook}) {
        const index = state.handbooks.findIndex(_handbook => _handbook.id === handbook.id)
        state.handbookForm.reset()

        if (index !== -1) {
            state.handbooks.splice(index, 1, handbook)
        } else {
            state.handbooks.push(role)
        }

        state.loading = false
    },
    [types.DELETE_HANDBOOK] (state, id) {
        const index = state.handbooks.findIndex(_handbook => _handbook.id === id)

        if (index !== -1) {
            state.handbooks.splice(index, 1)
        }
    },
}

// actions
export const actions = {
    
  async fetchHandbooks ({ commit }, queryInfo) {
    try {
            state.loading = true
            
            const { data } = await axios.get(route('handbook.all'), queryInfo)
            commit(types.FETCH_ALL_HANDBOOKS, data)
            
        } catch (error) {
            console.log(error.message)
        }
    },

    
  async fetchHandbook ({ commit }, id) {
    try {
            state.loading = true
            
            const { data } = await axios.get(route('handbook.show', id))
            commit(types.FETCH_HANDBOOK, data.data)
        } catch (error) {
            console.log(error.message)
        }
    },
    
    async saveHandbook ({ commit }, id) {
        try {
            state.loading = true
                
        if (id) {
            state.handbookForm.id = id;
        }

            const saveURL = state.handbookForm.id ? route('handbook.update', id) : route('handbook.store')
            const { data } = await (state.handbookForm.id ? state.handbookForm.put(saveURL) : state.handbookForm.post(saveURL))
            commit(types.SAVE_HANDBOOK, { handbook: data.data })
            return data
        } catch (error) {
            return state.handbookForm.errors
        }
    },

    async deleteHandbook ({ commit }, id) {
        try {
            const { data } = await axios.delete(route('handbook.delete', id))
            commit(types.DELETE_HANDBOOK, id)
            return data
        } catch (error) {
            const { response } = error
            return response.data
        }
    },
    
}