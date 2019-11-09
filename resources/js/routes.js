
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
        ],
    },
    {
        path: '*',
        redirect: '/',
    },
];
