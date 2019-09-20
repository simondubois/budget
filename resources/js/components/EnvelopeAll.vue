
<template>

    <div class="row">

        <div class="col-12">
            <h1 class="mb-3">
                <fontawesome-icon icon="balance" />
                {{ $t('envelope.all.name') }}
            </h1>
        </div>

        <div class="col-xl-6">

            <bs-card class="mb-3">

                <template slot="header-left">
                    <fontawesome-icon icon="linechart" />
                    {{ $t('envelope.attributes.cumulatedBalance') }}
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
                        entity="envelope"
                    />
                    <history-chart
                        entity="envelope"
                        :fields="['allocations', 'cumulatedBalance', 'expenses', 'incomes', 'periodBalance']"
                    />
                </template>

            </bs-card>

            <bs-card class="mb-3">

                <template slot="header">
                    <fontawesome-icon icon="barchart" />
                    {{ $t('envelope.all.distribution') }}
                </template>

                <envelope-distribution slot="body" />

            </bs-card>

        </div>

        <div class="col-xl-6">
            <bs-card class="mb-3 position-sticky">

                <template slot="header-left">
                    <fontawesome-icon icon="figures" />
                    {{ $t('envelope.figures.name', { date: currentMonth }) }}
                </template>

                <div
                    slot="header-right"
                    :class="'badge-' + monthlyBalanceContext"
                    class="badge"
                >
                    {{ monthlyBalanceText }}
                </div>

                <envelope-figures
                    slot="body"
                    :cumulated-balance="cumulatedBalance"
                    :monthly-allocations="monthlyAllocations"
                    :monthly-expenses="monthlyExpenses"
                    :monthly-incomes="monthlyIncomes"
                    :previous-cumulated-balance="previousCumulatedBalance"
                />

            </bs-card>
        </div>

        <transition
            mode="out-in"
            name="fade"
            appear
        >
            <router-view />
        </transition>

    </div>

</template>



<script>

    export default {
        computed: {
            cumulatedBalance: vue => vue.$store.getters['envelope/cumulatedBalance'],
            cumulatedBalanceContext: vue => vue.cumulatedBalance.getContext(vue.currency),
            cumulatedBalanceText: vue => vue.cumulatedBalance.getText(vue.currency),
            currency: vue => vue.$store.getters['currency/selected'],
            currentMonth: () => require('moment')().format('MMMM YYYY'),
            envelopes: vue => vue.$store.getters['envelope/all'],
            monthlyAllocations: vue => vue.$store.getters['envelope/monthlyAllocations'],
            monthlyBalance: vue => vue.$store.getters['envelope/monthlyBalance'],
            monthlyBalanceContext: vue => vue.monthlyBalance.getContext(vue.currency),
            monthlyBalanceText: vue => vue.monthlyBalance.getText(vue.currency),
            monthlyExpenses: vue => vue.$store.getters['envelope/monthlyExpenses'],
            monthlyIncomes: vue => vue.$store.getters['envelope/monthlyIncomes'],
            previousCumulatedBalance: vue => vue.$store.getters['envelope/previousCumulatedBalance'],
        },
        created() {
            this.$store.dispatch('envelopeHistory/refresh');
        },
        destroyed() {
            this.$store.dispatch('envelopeHistory/reset');
        },
    };

</script>



<style scoped>

    .position-sticky {
        top: 75px;
    }

</style>
