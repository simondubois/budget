
const state = {
    all: [],
    cumulatedBalance: new (require('../money.js').default)(),
    monthlyAllocations: new (require('../money.js').default)(),
    monthlyBalance: new (require('../money.js').default)(),
    monthlyExpenses: new (require('../money.js').default)(),
    monthlyIncomes: new (require('../money.js').default)(),
    previousCumulatedBalance: new (require('../money.js').default)(),
};

const getters = {
    all: state => state.all,
    cumulatedBalance: state => state.cumulatedBalance,
    find: state => envelopeId => state.all.find(envelope => envelope.id === envelopeId),
    monthlyAllocations: state => state.monthlyAllocations,
    monthlyBalance: state => state.monthlyBalance,
    monthlyExpenses: state => state.monthlyExpenses,
    monthlyIncomes: state => state.monthlyIncomes,
    previousCumulatedBalance: state => state.previousCumulatedBalance,
};

const mutations = {
    all: (state, all) => state.all = all.map(envelope => ({
        ...envelope,
        cumulatedBalance: window.app.makeMoney(envelope.cumulated_balance),
        monthlyAllocations: window.app.makeMoney(envelope.monthly_allocations),
        monthlyBalance: window.app.makeMoney(envelope.monthly_balance),
        monthlyExpenses: window.app.makeMoney(envelope.monthly_expenses),
        monthlyIncomes: window.app.makeMoney(envelope.monthly_incomes),
        previousCumulatedBalance: window.app.makeMoney(envelope.previous_cumulated_balance),
    })),
    cumulatedBalance: (state, cumulatedBalance) => state.cumulatedBalance = window.app.makeMoney(cumulatedBalance),
    monthlyAllocations: (state, monthlyAllocations) => state.monthlyAllocations = window.app.makeMoney(monthlyAllocations),
    monthlyBalance: (state, monthlyBalance) => state.monthlyBalance = window.app.makeMoney(monthlyBalance),
    monthlyExpenses: (state, monthlyExpenses) => state.monthlyExpenses = window.app.makeMoney(monthlyExpenses),
    monthlyIncomes: (state, monthlyIncomes) => state.monthlyIncomes = window.app.makeMoney(monthlyIncomes),
    previousCumulatedBalance: (state, previousCumulatedBalance) => state.previousCumulatedBalance = window.app.makeMoney(previousCumulatedBalance),
};

const actions = {
    refresh: ({ commit }) =>
        require('axios')
            .get('api/envelopes')
            .then(response => {
                commit('all', response.data.data);
                commit('cumulatedBalance', response.data.aggregates.cumulated_balance);
                commit('monthlyAllocations', response.data.aggregates.monthly_allocations);
                commit('monthlyBalance', response.data.aggregates.monthly_balance);
                commit('monthlyExpenses', response.data.aggregates.monthly_expenses);
                commit('monthlyIncomes', response.data.aggregates.monthly_incomes);
                commit('previousCumulatedBalance', response.data.aggregates.previous_cumulated_balance);
            }),
};

export {
    state,
    getters,
    mutations,
    actions,
};
