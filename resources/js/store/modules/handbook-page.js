import axios from 'axios'
import * as types from '../mutation-types'
import Form from 'vform'

// state
export const state = {
    loading: false,
    selected_handbook: null,
    handbooks_page: [],
    handbook_page: {},
    handbookPageForm: new Form({
        title: '',
        content: '',
    })
}

// getters
export const getters = {
    loading: state => state.loading,
    selected_handbook: state => state.selected_handbook,
    handbooks_page: state => state.handbooks_page,
    handbook_page: state => state.handbook_page,
    handbookPageForm: state => state.handbookPageForm
}

// mutations
export const mutations = {
    [types.FETCH_ALL_HANDBOOKS_PAGE] (state, {data}) {
        if(data.length > 0){
            let first_page = data[0];
            state.selected_handbook = first_page.id;        
        }
        state.handbooks_page = data        
        state.loading = false
    },

    [types.FETCH_HANDBOOK_PAGE] (state, {data}) {
        state.handbook_page = data
        state.loading = false
    },

    [types.SAVE_HANDBOOK_PAGE] (state, {handbookPage, type}) {
        const index = state.handbooks_page.findIndex(hb => hb.id === handbookPage.id)
        state.handbookPageForm.reset()

        if (index !== -1) {
            state.handbooks_page.splice(index, 1, handbookPage)
            
            state.handbook_page = handbookPage;
        } else {
            state.handbooks_page.push(handbookPage)
        }

        state.loading = false
    },

    [types.DELETE_HANDBOOK_PAGE] (state, id) {
        const index = state.handbooks_page.findIndex(_handbook => _handbook.id === id)

        if (index !== -1) {
            state.handbooks_page.splice(index, 1)
        }
    },
    
    [types.SELECT_HANDBOOK_PAGE] (state, {id}) {
        state.selected_handbook = id
    },
}

// actions
export const actions = {
    async selectHandbook ({ commit }, {id}) {
        commit(types.SELECT_HANDBOOK_PAGE, {id})
    },

    async getLastHandbook ({ commit }) {
        let first_page = state.handbooks_page[0];
        commit(types.SELECT_HANDBOOK_PAGE, {id: first_page.id})
        return first_page;
    },

    async fetchHandbooksPage ({ commit }, id) {
        
        try {
            state.loading = true
            
            const { data } = await axios.get(route('handbook_page.all', id))
            
            commit(types.FETCH_ALL_HANDBOOKS_PAGE, data)
            return data;
            
        } catch (error) {
            console.log(error)
            state.loading = false
        }
    },
    
    async fetchSingleHandbook ({ commit }, {id}) {

        try {
            state.loading = true

            const { data } = await axios.get(route('handbook_page.show', id))
    
            commit(types.FETCH_HANDBOOK_PAGE, data)
        } catch (error) {
            console.log(error)
            state.loading = false
        }
    },

    async saveHandbookPage ({ commit }, {id, type, handbookId}) {
        try {
            state.loading = true
                
            if (id) {
                state.handbookPageForm.id = id;
            }

            if(handbookId){
                state.handbookPageForm.handbook_id = handbookId;
            }

            const saveURL = state.handbookPageForm.id && type != 'save' ? route('handbook_page.update', id) : route('handbook_page.store')

            const { data } = await (state.handbookPageForm.id ? state.handbookPageForm.put(saveURL) : state.handbookPageForm.post(saveURL))

            commit(types.SAVE_HANDBOOK_PAGE, { handbookPage: data.data, type: state.handbookPageForm.id ? 'update' : 'save' })
            return data
        } catch (error) {
            state.loading = false
            console.log(error)
            return state.handbookPageForm.errors
        }
    },

    async deleteHandbookPage ({ commit }, id) {
        try {
            const { data } = await axios.delete(route('handbook_page.delete', id))
            commit(types.DELETE_HANDBOOK_PAGE, id)
            return data
        } catch (error) {
            state.loading = false
            const { response } = error
            return response.data
        }
    },
}