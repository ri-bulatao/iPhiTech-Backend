import axios from 'axios'
import * as types from '../mutation-types'
import { Country, State, City }  from 'country-state-city';

// state
export const state = {
  users: null,
  user: null,
  countries: null,
  states: null,
  cities: null,
}

// getters
export const getters = {
  users: state => state.users,
  user: state => state.user,
  countries: state => state.countries,
  cities: state => state.cities,
  states: state => state.states
}

// mutations
export const mutations = {
  [types.FETCH_USERS] (state, { data }) {
    state.users = data
  },

  [types.FETCH_USER_SUCCESS] (state, { user }) {
    state.user = user
  },

  [types.FETCH_USER_FAILURE] (state) {
    state.user = null
  },

  [types.UPDATE_USER] (state, { data }) {
    state.user = data
  },

  [types.FETCH_USER] (state, { data }) {
    state.user = data
  },

  [types.SAVE_USER] (state, { user }) {
    state.user = user
  },

  [types.FETCH_COUNTRIES] (state, { data }) {
    state.countries = data
  },

  [types.FETCH_COUNTRIES_FAILURE] (state) {
    state.countries = null
  },

  [types.FETCH_CITIES] (state, { data }) {
    state.cities = data
  },

  [types.FETCH_CITIES_FAILURE] (state) {
    state.cities = null
  },

  [types.FETCH_STATES] (state, { data }) {
    state.states = data
  },

  [types.FETCH_STATES_FAILURE] (state) {
    state.states = null
  },
}

// actions
export const actions = {
  async fetchUsers ({ commit }) {
    try {
      const { data } = await axios.get(route('admin_user.list'))
      commit(types.FETCH_USERS, { data: data.data })
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  async fetchSingleUser ({ commit }, { id }) {
    try {
      const { data } = await axios.get(route('admin_user.single', id))
      commit(types.FETCH_USER, { data: data.data })
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  async updateUser ({}, { id, form }) {
    return new Promise((resolve, reject) => {
      axios.put(route('admin_user.update', id), form)
        .then((response) => {
          resolve(response);

        }).catch((error)=>{
          reject(error)
        })
    })
  },

  async saveUser ({}, payload) {
    return new Promise((resolve, reject) => {
      axios.post(route('admin_user.store', payload))
        .then((response) => {
          resolve(response);
        }).catch((error)=>{
          reject(error)
        })
    })
  },

  async removeUser ({}, { id }) {
    return new Promise((resolve, reject) => {
      axios.delete(route('admin_user.delete', id))
        .then((response) => {
          resolve(response);

        }).catch((error)=>{
          reject(error)
        })
    })
  },

  fetchCountries ({ commit }) {
    try {
      let countries = Country.getAllCountries();
      commit(types.FETCH_COUNTRIES, { data: countries })
    } catch (e) {
      commit(types.FETCH_COUNTRIES_FAILURE)
    }
  },

  // State or Province
  fetchStatesOfCountry ({ commit }, { countryCode }) {
    try {
      let states = State.getStatesOfCountry(countryCode);
      console.log(states)
      commit(types.FETCH_STATES, { data: states })
    } catch (e) {
      commit(types.FETCH_STATES_FAILURE)
    }
  },

  fetchCitiesOfState ({ commit }, { countryCode }) {
    try {
      let cities = City.getCitiesOfCountry(countryCode);
      commit(types.FETCH_CITIES, { data: cities })
    } catch (e) {
      commit(types.FETCH_CITIES_FAILURE)
    }
  },
}
