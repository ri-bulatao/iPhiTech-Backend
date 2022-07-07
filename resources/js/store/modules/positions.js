import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  positions: null,
  position: null,
}

// getters
export const getters = {
  positions: state => state.positions
}

// mutations
export const mutations = {
  [types.FETCH_POSITIONS] (state, { data }) {
    state.positions = data
  },

  [types.FETCH_POSITION_SUCCESS] (state, { position }) {
    state.position = position
  },

  [types.FETCH_POSITION_FAILURE] (state) {
    state.position = null
  },

  [types.UPDATE_POSITION] (state, { data }) {
    state.positions = data
  },

  [types.SAVE_POSITION] (state, { position }) {
    state.position = position
  }
}

// actions
export const actions = {
  async fetchPositions ({ commit }) {
    
    try {
      const { data } = await axios.get(route('position.list'))
      commit(types.FETCH_POSITIONS, { data: data.data })
    } catch (e) {
      commit(types.FETCH_POSITION_FAILURE)
    }
  },

  async savePosition ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      axios.post(route('position.store', payload))
        .then((response) => {
          resolve(response);

        }).catch((error)=>{
          reject(error)
        })
    })
  },

  async removePosition ({ commit }, {id}) {
    return new Promise((resolve, reject) => {
      axios.delete(route('position.delete', id))
        .then((response) => {
          resolve(response);

        }).catch((error)=>{
          reject(error)
        })
    })
  },
}
