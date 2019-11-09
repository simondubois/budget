
const state = {
    all: [],
    cumulatedBalance: new (require('../money.js').default)(),
    monthlyBalance: new (require('../money.js').default)(),
};

const getters = {
    all: state => state.all,
    banks: state => new Set(state.all.map(account => account.bank)),
    cumulatedBalance: state => state.cumulatedBalance,
    find: state => accountId => state.all.find(account => account.id === accountId),
    monthlyBalance: state => state.monthlyBalance,
    whereBank: state => bank => state.all.filter(account => account.bank === bank),
};

const mutations = {
    all: (state, all) => state.all = all.map(account => ({
        ...account,
        cumulatedBalance: window.app.makeMoney(account.cumulated_balance),
        monthlyBalance: window.app.makeMoney(account.monthly_balance),
    })),
    cumulatedBalance: (state, cumulatedBalance) => state.cumulatedBalance = window.app.makeMoney(cumulatedBalance),
    monthlyBalance: (state, monthlyBalance) => state.monthlyBalance = window.app.makeMoney(monthlyBalance),
};

const actions = {
    refresh: ({ commit }) =>
        require('axios')
            .get('api/accounts')
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
