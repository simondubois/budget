
<template>

    <chart-bar :chart-data="{ datasets, labels }" />

</template>



<script>

    export default {
        computed: {
            currency: vue => vue.$store.getters['currency/selected'],
            datasets: vue => [
                {
                    type: 'bar',
                    label: vue.$t('envelope.attributes.cumulatedBalance'),
                    tooltip: vue.$store.getters['envelope/all'].map(envelope => envelope.cumulatedBalance.getText(vue.currency)),
                    data: vue.$store.getters['envelope/all'].map(envelope => envelope.cumulatedBalance.getNumber(vue.currency)),
                    backgroundColor: vue.colors.blue.light,
                    borderColor: vue.colors.blue.medium,
                    hoverBackgroundColor: vue.colors.blue.medium,
                    hoverBorderColor: vue.colors.blue.strong,
                    pointBackgroundColor: vue.colors.blue.medium,
                    pointBorderColor: vue.colors.blue.medium,
                    pointHoverBackgroundColor: vue.colors.blue.strong,
                    pointHoverBorderColor: vue.colors.blue.strong,
                },
                {
                    type: 'bar',
                    label: vue.$t('envelope.attributes.monthlyBalance'),
                    tooltip: vue.$store.getters['envelope/all'].map(envelope => envelope.monthlyBalance.getText(vue.currency)),
                    data: vue.$store.getters['envelope/all'].map(envelope => envelope.monthlyBalance.getNumber(vue.currency)),
                    backgroundColor: vue.colors.gray5.light,
                    borderColor: vue.colors.gray5.medium,
                    hoverBackgroundColor: vue.colors.gray5.medium,
                    hoverBorderColor: vue.colors.gray5.strong,
                    pointBackgroundColor: vue.colors.gray5.medium,
                    pointBorderColor: vue.colors.gray5.medium,
                    pointHoverBackgroundColor: vue.colors.gray5.strong,
                    pointHoverBorderColor: vue.colors.gray5.strong,
                },
            ],
            labels: vue => vue.$store.getters['envelope/all'].map(envelope => envelope.name),
        },
    };

</script>
