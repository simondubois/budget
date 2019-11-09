
<template>

    <i :class="classes" />

</template>



<script>

    const iconClasses = {
        '': '',
        // actions
        close: 'fa-times',
        create: 'fa-plus',
        delete: 'fa-trash',
        duplicate: 'fa-copy',
        edit: 'fa-pen',
        next: 'fa-chevron-right',
        open: 'fa-caret-up',
        previous: 'fa-chevron-left',
        reset: 'fa-redo',
        restore: 'fa-history',
        save: 'fa-save',
        search: 'fa-search',
        sync: 'fa-sync',
        valid: 'fa-check',
        // entities
        account: 'fa-archive',
        allocation: 'fa-sliders-h',
        balance: 'fa-balance-scale',
        currency: 'fa-chart-line',
        distribution: 'fa-chart-pie',
        envelope: 'fa-envelope',
        exchange: 'fa-exchange-alt',
        expense: 'fa-hand-holding-usd',
        income: 'fa-hand-holding-usd fa-flip-horizontal',
        operation: 'fa-exchange-alt',
        transfer: 'fa-exchange-alt',
        // feedback
        barchart: 'fa-chart-bar',
        done: 'fa-check-square',
        figures: 'fa-calculator',
        linechart: 'fa-chart-line',
        menu: 'fa-bars',
        negative: 'fa-arrow-down',
        null: 'fa-minus',
        positive: 'fa-arrow-up',
        undone: 'fa-square',
    };

    export default {
        props: {
            icon: {
                type: String,
                default: '',
                validator: icon => iconClasses[icon] !== undefined,
            },
            rawIcon: {
                type: String,
                default: '',
            },
            spin: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            classes: vue => ({
                fa: true,
                'fa-fw': true,
                'fa-sm': true,
                'fa-spin': vue.spin,
                [vue.iconClass]: true,
                [vue.rawIcon]: true,
            }),
            iconClass: vue => iconClasses[vue.icon],
        },
    };

</script>
