
export default [
    {
        path: '/',
        redirect: { name: 'envelope-all' },
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
                children: [
                    {
                        path: 'new',
                        name: 'account-create',
                        component: require('./components/AccountCreate.vue').default,
                    },
                ],
            },
            {
                path: ':accountId',
                name: 'account-show',
                component: require('./components/AccountShow.vue').default,
                meta: { showCurrencySelector: true },
                children: [
                    {
                        path: 'edit',
                        name: 'account-edit',
                        component: require('./components/AccountEdit.vue').default,
                    },
                ],
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
            {
                path: '/',
                name: 'envelope-all',
                component: require('./components/EnvelopeAll.vue').default,
                meta: { showCurrencySelector: true },
                children: [
                    {
                        path: 'new',
                        name: 'envelope-create',
                        component: require('./components/EnvelopeCreate.vue').default,
                    },
                ],
            },
            {
                path: ':envelopeId',
                name: 'envelope-show',
                component: require('./components/EnvelopeShow.vue').default,
                meta: { showCurrencySelector: true },
                children: [
                    {
                        path: 'edit',
                        name: 'envelope-edit',
                        component: require('./components/EnvelopeEdit.vue').default,
                    },
                ],
            },
        ],
    },
    {
        path: '/operations',
        name: 'operation-all',
        components: {
            default: require('./components/OperationAll.vue').default,
            navbar: require('./components/OperationNavbar.vue').default,
        },
        children: [
            {
                path: 'new',
                name: 'operation-create',
                component: require('./components/OperationCreate.vue').default,
            },
        ],
    },
    {
        path: '*',
        redirect: '/',
    },
];
