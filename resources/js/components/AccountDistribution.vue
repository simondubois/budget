
<template>

    <chart-progress
        :chart-data="{ datasets }"
        :style="{ height: '50px' }"
    />

</template>



<script>

    export default {
        computed: {
            accounts: vue => vue.$store.getters['account/all']
                .filter(account => account.cumulatedBalance.getNumber(vue.currency))
                .sort((a, b) =>
                    a.cumulatedBalance.getNumber(vue.currency) - b.cumulatedBalance.getNumber(vue.currency)
                ),
            currency: vue => vue.$store.getters['currency/selected'],
            datasets: vue => vue.accounts.map((account, index) => ({
                label: account.name,
                tooltip: account.name
                    + ': ' + account.cumulatedBalance.getText(vue.currency)
                    + ' (' + Math.round(account.cumulatedBalance.getNumber(vue.currency) / vue.total * 100) + '%)',
                data: [account.cumulatedBalance.getNumber(vue.currency)],
                backgroundColor: vue.colors['gray' + (9 - index * vue.threshold)].medium,
                borderColor: vue.colors['gray' + (9 - index * vue.threshold)].medium,
                hoverBackgroundColor: vue.colors['gray' + (9 - index * vue.threshold)].strong,
                hoverBorderColor: vue.colors['gray' + (9 - index * vue.threshold)].strong,
            })),
            threshold: vue => Math.max(1, Math.floor(9 / vue.accounts.length)),
            total: vue => vue.accounts
                .map(account => account.cumulatedBalance.getNumber(vue.currency))
                .reduce((total, cumulatedBalance) => total + cumulatedBalance, 0),
        },
    };

</script>
