
const state = {
    count: 0,
};

const getters = {
    loading: state => state.count > 0,
};

const mutations = {
    decrease: (state) => --state.count,
    increase: (state) => ++state.count,
};

const actions = {
    finish: ({ commit }) => commit('decrease'),
    start: ({ commit }) => commit('increase'),
};

export {
    state,
    getters,
    mutations,
    actions,
};
