
<script>

    export default {
        extends: require('vue-chartjs').Bar,
        mixins: [require('vue-chartjs').mixins.reactiveProp],
        data: vue => ({
            options: {
                elements: {
                    line: {
                        borderWidth: 2,
                    },
                    rectangle: {
                        borderWidth: 1,
                    },
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: value => vue.makeMoney({ [vue.currency.iso]: value }).getText(vue.currency),
                        },
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: (tooltipItem, chartData) =>
                            chartData.datasets[tooltipItem.datasetIndex].tooltip[tooltipItem.index],
                    },
                },
            },
        }),
        computed: {
            currency: vue => vue.$store.getters['currency/selected'],
        },
        mounted() {
            this.renderChart(this.chartData, this.options);
        },
    };

</script>
