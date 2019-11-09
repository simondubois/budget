
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
        ],
    },
    {
        path: '*',
        redirect: '/',
    },
];
