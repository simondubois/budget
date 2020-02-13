
<template>

    <div class="container">
        <chart-bar :chart-data="{ datasets, labels }" />
    </div>

</template>



<script>

    export default {
        data: () => ({
            rates: {},
        }),
        computed: {
            currencies: vue => vue.$store.getters['currency/all'].filter(currency => currency.iso !== vue.currency.iso),
            toCurrency: vue => vue.$store.getters['currency/selected'],
            datasets: vue => Object.keys(vue.rates)
                .map(iso => vue.$store.getters['currency/find'](iso))
                .map((fromCurrency, index) => ({
                    type: 'line',
                    label: fromCurrency.name,
                    tooltip: Object.values(vue.rates[fromCurrency.iso])
                        .map(rate => vue.makeMoney({ [fromCurrency.iso]: 1, [vue.toCurrency.iso]: rate }))
                        .map(money => money.getText(fromCurrency) + ' = ' + money.getText(vue.toCurrency)),
                    data: Object.values(vue.rates[fromCurrency.iso]),
                    backgroundColor: Object.values(vue.colors)[index].light,
                    borderColor: Object.values(vue.colors)[index].medium,
                    hoverBackgroundColor: Object.values(vue.colors)[index].medium,
                    hoverBorderColor: Object.values(vue.colors)[index].strong,
                    pointBackgroundColor: Object.values(vue.colors)[index].medium,
                    pointBorderColor: Object.values(vue.colors)[index].medium,
                    pointHoverBackgroundColor: Object.values(vue.colors)[index].strong,
                    pointHoverBorderColor: Object.values(vue.colors)[index].strong,
                })),
            dateKeys: vue => vue.dates.map(date => date.format('YYYY-MM')),
            dates: vue => new Array(vue.end.diff(vue.start, 'month') + 1)
                .fill(undefined)
                .map((value, index) => vue.start.clone().add(index, 'month')),
            end: () => require('moment')().endOf('month'),
            labels: vue => vue.dates.map(date => date.format('MMM YY')),
            start: () => require('moment')(document.head.querySelector("[name=start-date]").content).startOf('month'),
        },
        watch: {
            toCurrency: {
                handler(toCurrency) {
                    require('axios')
                        .get('api/currencies/history/' + toCurrency.iso, { params: { dates: this.dateKeys } })
                        .then(response => this.rates = response.data);
                },
                immediate: true,
            },
        },
    };

</script>
