
const state = {
    all: [],
    selected: JSON.parse(document.head.querySelector("[name=default-currency]").content),
};

const getters = {
    all: state => state.all,
    find: state => currencyIso => state.all.find(currency => currency.iso === currencyIso),
    selected: state => state.selected,
};

const mutations = {
    all: (state, all) => state.all = all,
    selected: (state, currency) => state.selected = currency,
};

const actions = {
    refresh: ({ commit }) =>
        require('axios')
            .get('api/currencies')
            .then(response => commit('all', response.data.data)),
    select: ({ commit }, currency) => commit('selected', currency),
};

export {
    state,
    getters,
    mutations,
    actions,
};
