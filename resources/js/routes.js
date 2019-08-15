
export default [
    {
        path: '/',
        redirect: { name: 'account-all' },
    },
    {
        path: '/accounts',
        components: {
            default: require('./components/AccountIndex.vue').default,
            navbar: require('./components/AccountNavbar.vue').default,
        },
        children: [
            {
                path: '/',
                name: 'account-all',
                component: require('./components/AccountAll.vue').default,
                meta: { showCurrencySelector: true },
            },
            {
                path: ':accountId',
                name: 'account-show',
                component: require('./components/AccountShow.vue').default,
                meta: { showCurrencySelector: true },
            },
        ],
    },
    {
        path: '/envelopes',
        components: {
            default: require('./components/EnvelopeIndex.vue').default,
            navbar: require('./components/EnvelopeNavbar.vue').default,
        },
        children: [
        ],
    },
    {
        path: '*',
        redirect: '/',
    },
];
