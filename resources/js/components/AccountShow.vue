
<template>

    <div class="row">

        <div class="col-12">
            <h1 class="mb-3">

                <div class="d-flex flex-wrap align-items-end">

                    <div class="mr-1">
                        <fontawesome-icon icon="account" />
                        {{ name }}
                    </div>

                    <div class="flex-fill text-right">
                        <div class="badge badge-dark">
                            {{ currencyUnit }}
                        </div>
                    </div>

                </div>

                <div class="small text-muted">
                    {{ bank }}
                </div>

            </h1>
        </div>

        <div class="col-xl-6">
            <bs-card class="mb-3">

                <template slot="header-left">
                    <fontawesome-icon icon="linechart" />
                    {{ $t('account.attributes.cumulatedBalance') }}
                </template>

                <div
                    slot="header-right"
                    :class="'badge-' + cumulatedBalanceContext"
                    class="badge"
                >
                    {{ cumulatedBalanceText }}
                </div>

                <template slot="body">
                    <history-nav
                        class="mb-2"
                        entity="account"
                    />
                    <history-chart
                        entity="account"
                        :fields="['cumulatedBalance']"
                    />
                </template>

            </bs-card>
        </div>

        <div class="col-xl-6">
            <bs-card class="mb-3">

                <template slot="header-left">
                    <fontawesome-icon icon="barchart" />
                    {{ $t('account.attributes.monthlyBalance') }}
                </template>

                <div
                    slot="header-right"
                    :class="'badge-' + monthlyBalanceContext"
                    class="badge"
                >
                    {{ monthlyBalanceText }}
                </div>

                <template slot="body">
                    <history-nav
                        class="mb-2"
                        entity="account"
                    />
                    <history-chart
                        entity="account"
                        :fields="['expenses', 'incomes', 'periodBalance']"
                    />
                </template>

            </bs-card>
        </div>

    </div>

</template>



<script>

    export default {
        computed: {
            account: vue => {
                vue.$store.dispatch('accountHistory/refresh', vue.id);
                return vue.$store.getters['account/find'](vue.id) || {};
            },
            bank: vue => vue.account.bank,
            cumulatedBalance: vue => vue.account.cumulatedBalance || vue.makeMoney(),
            cumulatedBalanceContext: vue => vue.cumulatedBalance.getContext(vue.currency),
            cumulatedBalanceText: vue => vue.cumulatedBalance.getText(vue.currency),
            currency: vue => vue.account.currency || vue.$store.getters['currency/selected'],
            currencyUnit: vue => vue.currency.unit,
            id: vue => parseInt(vue.$route.params.accountId),
            monthlyBalance: vue => vue.account.monthlyBalance || vue.makeMoney(),
            monthlyBalanceContext: vue => vue.monthlyBalance.getContext(vue.currency),
            monthlyBalanceText: vue => vue.monthlyBalance.getText(vue.currency),
            name: vue => vue.account.name,
        },
        destroyed() {
            this.$store.dispatch('accountHistory/reset');
        },
    };

</script>
