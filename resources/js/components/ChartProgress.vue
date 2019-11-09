
<script>

    export default {
        extends: require('vue-chartjs').HorizontalBar,
        mixins: [require('vue-chartjs').mixins.reactiveProp],
        data: () => ({
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 1,
                    },
                },
                legend: {
                    display: false,
                },
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        stacked: true,
                    }],
                    yAxes: [{
                        display: false,
                        stacked: true,
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: (tooltipItem, chartData) => chartData.datasets[tooltipItem.datasetIndex].tooltip,
                        title: () => '',
                    },
                    mode: 'nearest',
                },
            },
        }),
        mounted() {
            this.renderChart(this.chartData, this.options);
        },
    };

</script>
