
<template>

    <div class="row">

        <div class="col-12">
            <h1 class="mb-3">

                <fontawesome-icon :raw-icon="icon" />

                {{ name }}

                <router-link
                    :title="$t('envelope.edit.name', { envelopeId: id })"
                    :to="{ name: 'envelope-edit' }"
                    class="ml-1 btn btn-secondary btn-sm"
                >
                    <fontawesome-icon icon="edit" />
                </router-link>

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
        </div>

        <div class="col-xl-6">
            <bs-card class="mb-3">

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
            cumulatedBalance: vue => vue.envelope.cumulatedBalance || vue.makeMoney(),
            cumulatedBalanceContext: vue => vue.cumulatedBalance.getContext(vue.currency),
            cumulatedBalanceText: vue => vue.cumulatedBalance.getText(vue.currency),
            currency: vue => vue.$store.getters['currency/selected'],
            currentMonth: () => require('moment')().format('MMMM YYYY'),
            envelope: vue => {
                vue.$store.dispatch('envelopeHistory/refresh', vue.id);
                return vue.$store.getters['envelope/find'](vue.id) || {};
            },
            icon: vue => vue.envelope.icon,
            id: vue => parseInt(vue.$route.params.envelopeId),
            monthlyAllocations: vue => vue.envelope.monthlyAllocations || vue.makeMoney(),
            monthlyBalance: vue => vue.envelope.monthlyBalance || vue.makeMoney(),
            monthlyBalanceContext: vue => vue.monthlyBalance.getContext(vue.currency),
            monthlyBalanceText: vue => vue.monthlyBalance.getText(vue.currency),
            monthlyExpenses: vue => vue.envelope.monthlyExpenses || vue.makeMoney(),
            monthlyIncomes: vue => vue.envelope.monthlyIncomes || vue.makeMoney(),
            name: vue => vue.envelope.name,
            previousCumulatedBalance: vue => vue.envelope.previousCumulatedBalance || vue.makeMoney(),
        },
        destroyed() {
            this.$store.dispatch('envelopeHistory/reset');
        },
    };

</script>
