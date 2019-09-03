
const snakeToCamelCase = str => str.replace(/([-_]\w)/g, g => g[1].toUpperCase());

export default path => ({

    state: {
        all: {},
        date: require('moment')(),
        period: 'latest',
        requestId: null,
        start: require('moment')(document.head.querySelector("[name=start-date]").content),
    },

    getters: {
        date: state => state.date,
        dateKeys: (state, getters) => {
            if (state.period === 'latest') {
                return getters.dates.map(date => date.format('YYYY-MM'));
            }
            if (state.period === 'monthly') {
                return getters.dates.map(date => date.format('YYYY-MM'));
            }
            if (state.period === 'yearly') {
                return getters.dates.map(date => date.format('YYYY'));
            }
        },
        dateLabel: (state) => state.date.format('YYYY'),
        dateLabels: (state, getters) => {
            if (state.period === 'latest') {
                return getters.dates.map(date => date.format('MMM YY'));
            }
            if (state.period === 'monthly') {
                return getters.dates.map(date => date.format('MMM'));
            }
            if (state.period === 'yearly') {
                return getters.dates.map(date => date.format('YYYY'));
            }
        },
        dates: state => {
            let start = require('moment')().startOf('month').subtract(1, 'year');
            let end = require('moment')().endOf('month');
            let step = 'month';
            if (state.period === 'monthly') {
                start = state.date.clone().startOf('year');
                end = state.date.clone().endOf('year');
                step = 'month';
            }
            if (state.period === 'yearly') {
                start = state.start.clone().startOf('year');
                end = require('moment')().endOf('year');
                step = 'year';
            }
            return new Array(end.diff(start, step) + 1)
                .fill(undefined)
                .map((value, index) => start.clone().add(index, step));
        },
        find: state => key => state.all[key] ? Object.values(state.all[key]) : [],
        isCurrentRequest: state => response => response.config.url + JSON.stringify(response.config.params) === state.requestId,
        isMinDate: state => state.date.isSameOrBefore(state.start, 'year'),
        isMaxDate: state => state.date.isSameOrAfter(undefined, 'year'),
        period: state => state.period,
    },

    mutations: {
        all: (state, all) => state.all = Object.keys(all).reduce((mutated, field) => {
            mutated[snakeToCamelCase(field)] = Object.keys(all[field]).reduce((mutated, date) => {
                mutated[date] = window.app.makeMoney(all[field][date]);
                return mutated;
            }, {});
            return mutated;
        }, {}),
        date: (state, date) => state.date = date,
        period: (state, period) => state.period = period,
        requestId: (state, requestId) => state.requestId = requestId,
        start: (state, start) => state.start = require('moment').min(start, state.start),
    },

    actions: {
        nextDate: ({ commit, dispatch, state }) => {
            commit('date', state.date.clone().add(1, 'year'));
            dispatch('refresh');
        },
        period: ({ commit, dispatch }, period) => {
            commit('period', period);
            dispatch('refresh');
        },
        previousDate: ({ commit, dispatch, state }) => {
            commit('date', state.date.clone().subtract(1, 'year'));
            dispatch('refresh');
        },
        refresh: ({ commit, getters }, id) => {
            const url = (id ? 'api/' + path + '/history/' + id : 'api/' + path + '/history');
            commit('requestId', url + JSON.stringify({ dates: getters.dateKeys }));
            require('axios')
                .get(url, { params: { dates: getters.dateKeys } })
                .then(response =>
                    getters.isCurrentRequest(response) ? response : Promise.reject('Concurrent request canceled.')
                )
                .then(response => commit('all', response.data));
        },
        reset: ({ commit }) => commit('all', {}),
        updateStart: ({ commit }, start) => commit('start', start),
    },

});
