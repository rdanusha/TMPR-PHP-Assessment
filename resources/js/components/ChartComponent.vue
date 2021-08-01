<template>
    <div class="container">
        <h3>Steps in onboarding</h3>
        <ol>
            <li>Create account - 0%</li>
            <li>Activate account - 20%</li>
            <li>Provide profile information - 40%</li>
            <li>What jobs are you interested in? - 50%</li>
            <li>Do you have relevant experience in these jobs? - 70%</li>
            <li>Are you a freelancer? - 90%</li>
            <li>Waiting for approval - 99%</li>
            <li>Approval - 100%</li>
        </ol>
        <highcharts class="chart" :options="chartOptions" :updateArgs="updateArgs"></highcharts>
    </div>
</template>

<script>
export default {
    data() {
        return {
            updateArgs: [true, true, {duration: 1000}],
            chartOptions: {
                xAxis: {
                    categories: [],
                    title: {
                        text: "Onboarding Steps (%)"
                    },
                    labels: {
                        format: "{value}%"
                    },
                    min: 0
                },
                yAxis: {
                    title: {
                        text: "Total Onboarded Users (%)"
                    },
                    labels: {
                        format: "{value}%"
                    },
                    min: 0,
                    max: 100
                },
                tooltip: {
                    valueSuffix: '%'
                },
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Weekly Retention'
                },
                series: [],

            }
        }
    },
    mounted: function () {
        this.$http.get('/api/charts/get-weekly-retention-data')
            .then(response => {
                this.chartOptions.series = response.data.records;
                this.chartOptions.xAxis.categories = response.data.labels;
            });
    },
}
</script>
