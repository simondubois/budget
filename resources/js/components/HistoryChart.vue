
<template>

    <chart-bar :chart-data="{ datasets, labels }" />

</template>



<script>

    export default {
        props: {
            entity: {
                type: String,
                required: true,
            },
            fields: {
                type: Array,
                required: true,
            },
        },
        data: () => ({
            chartColors: {
                allocations: 'gray5',
                cumulatedBalance: 'gray9',
                cumulatedSavings: 'blue',
                expenses: 'red',
                incomes: 'green',
                periodBalance: 'gray9',
                periodSavings: 'blue',
            },
            chartHidden: {
                allocations: true,
                cumulatedBalance: false,
                cumulatedSavings: false,
                expenses: true,
                incomes: true,
                periodBalance: false,
                periodSavings: false,
            },
            chartTypes: {
                allocations: 'line',
                cumulatedBalance: 'line',
                cumulatedSavings: 'line',
                expenses: 'line',
                incomes: 'line',
                periodBalance: 'bar',
                periodSavings: 'bar',
            },
        }),
        computed: {
            currency: vue => vue.$store.getters['currency/selected'],
            datasets: vue => vue.fields.map(field => ({
                type: vue.chartTypes[field],
                label: vue.$t(vue.entity + '.attributes.' + field),
                tooltip: vue.$store
                    .getters[vue.entity + 'History/find'](field)
                    .map(amount => amount.getText(vue.currency)),
                data: vue.$store
                    .getters[vue.entity + 'History/find'](field)
                    .map(amount => amount.getNumber(vue.currency)),
                backgroundColor: vue.colors[vue.chartColors[field]].light,
                borderColor: vue.colors[vue.chartColors[field]].medium,
                hidden: vue.chartHidden[field],
                hoverBackgroundColor: vue.colors[vue.chartColors[field]].medium,
                hoverBorderColor: vue.colors[vue.chartColors[field]].strong,
                pointBackgroundColor: vue.colors[vue.chartColors[field]].medium,
                pointBorderColor: vue.colors[vue.chartColors[field]].medium,
                pointHoverBackgroundColor: vue.colors[vue.chartColors[field]].strong,
                pointHoverBorderColor: vue.colors[vue.chartColors[field]].strong,
            })),
            labels: vue => vue.$store.getters[vue.entity + 'History/dateLabels'],
        },
    };

</script>
