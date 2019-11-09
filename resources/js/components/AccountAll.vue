
<template>

    <div class="row">

        <div class="col-12">
            <h1 class="mb-3">
                <fontawesome-icon icon="balance" />
                {{ $t('account.all.name') }}
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

            </bs-card>
        </div>

        <div
            v-if="hasAccounts"
            class="col-12"
        >
            <bs-card class="mb-3">

                <template slot="header">
                    <fontawesome-icon icon="distribution" />
                    {{ $t('account.all.distribution') }}
                </template>

                <account-distribution slot="body" />

            </bs-card>
        </div>

    </div>

</template>



<script>

    export default {
        computed: {
            currency: vue => vue.$store.getters['currency/selected'],
            cumulatedBalanceContext: vue => vue.$store.getters['account/cumulatedBalance'].getContext(vue.currency),
            cumulatedBalanceText: vue => vue.$store.getters['account/cumulatedBalance'].getText(vue.currency),
            hasAccounts: vue => vue.$store.getters['account/all'].length,
            monthlyBalanceContext: vue => vue.$store.getters['account/monthlyBalance'].getContext(vue.currency),
            monthlyBalanceText: vue => vue.$store.getters['account/monthlyBalance'].getText(vue.currency),
        },
    };

</script>
