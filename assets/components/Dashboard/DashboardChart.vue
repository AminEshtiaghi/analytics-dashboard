<template>
    <div class="flex flex-wrap my-6">
        <div v-if="isLoading" class="object-center mx-auto">
            <img src="../../images/rotate.svg"
                 class="animate-spin w-12 h-12 mx-auto" />
            <span>
                Please wait! data is retrieving...
            </span>
        </div>
        <div id="graph" class="w-full graph" >
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import * as Highcharts from 'highcharts';
    import {AnalyticsRequestData} from "../../models/AnalyticsRequestData";
    import {DataPoint} from "../../models/DataPoint";

    interface iHighChartData {
        y: number;
        count: number;
    }

    interface iGraph {
        data: Array<iHighChartData>;
        graphType: string;
        categories: Array<string>;
    }

    @Component
    export default class DashboardChart extends Vue {
        public isLoading: boolean = false;
        public get Data(): iGraph {
            const data: Array<iHighChartData> = [];
            const graphType = 'unknown';
            const categories: Array<string> = [];

            return {
                data,
                graphType,
                categories,
            } as iGraph;
        };
        public fetchChart(inputs: AnalyticsRequestData): void {

            this.isLoading = true;

            this.$store.dispatch('analytics/fetchData', inputs)
            .then((data: Array<DataPoint>) => {

                this.Data.data = [];
                this.Data.categories = [];
                this.Data.graphType = 'line';

                data.forEach((dataPoint: DataPoint) => {
                    this.Data.data.push({
                        y: parseFloat(dataPoint.average.toFixed(2)),
                        count: dataPoint.count
                    } as iHighChartData);
                    this.Data.categories.push(dataPoint.datePoint);
                });

                this.graph();

                this.isLoading = false;

            });

        };
        graph() {
            Highcharts.chart({
                chart: {
                    renderTo: "graph",
                    type: this.Data.graphType
                },
                credits: {
                    text: 'Analytics Dashboard Code Challenge',
                    href: 'https://github.com/AminEshtiaghi/analytics-dashboard'
                },
                title: false as Highcharts.TitleOptions,
                xAxis: {
                    categories: this.Data.categories,
                    crosshair: true
                } as Highcharts.XAxisOptions,
                yAxis: {
                    title: false,
                    labels: {
                        format: "{value}"
                    },
                    opposite: false,
                    max: 100.00,
                    min: 0
                } as Highcharts.YAxisOptions,
                tooltip: {
                    formatter: function () :string {
                       return `
                       <div>
                            <small>${this.x}</small>
                       </div>
                       <br>
                       <div>
                            <span><b>Score:</b> ${this.y}</span>
                       </div>
                       <br>
                       <div>
                            <span><b>Review count:</b> ${this.point.count}</span>
                       </div>
                        `;
                    }
                },
                series: [
                    {
                        name: "Score",
                        type: this.Data.graphType,
                        data: this.Data.data,
                    },
                ]
            });
        };
    }

</script>