
const state = {
    all: [],
    cumulatedBalance: new (require('../money.js').default)(),
    monthlyBalance: new (require('../money.js').default)(),
};

const getters = {
    all: state => state.all,
    cumulatedBalance: state => state.cumulatedBalance,
    find: state => envelopeId => state.all.find(envelope => envelope.id === envelopeId),
    monthlyBalance: state => state.monthlyBalance,
};

const mutations = {
    all: (state, all) => state.all = all.map(envelope => ({
        ...envelope,
        cumulatedBalance: window.app.makeMoney(envelope.cumulated_balance),
        monthlyBalance: window.app.makeMoney(envelope.monthly_balance),
    })),
    cumulatedBalance: (state, cumulatedBalance) => state.cumulatedBalance = window.app.makeMoney(cumulatedBalance),
    monthlyBalance: (state, monthlyBalance) => state.monthlyBalance = window.app.makeMoney(monthlyBalance),
};

const actions = {
    refresh: ({ commit }) =>
        require('axios')
            .get('api/envelopes')
            .then(response => {
                commit('all', response.data.data);
                commit('cumulatedBalance', response.data.aggregates.cumulated_balance);
                commit('monthlyBalance', response.data.aggregates.monthly_balance);
            }),
};

export {
    state,
    getters,
    mutations,
    actions,
};
