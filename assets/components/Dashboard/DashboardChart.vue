<template>
    <div class="flex flex-wrap my-6">
        <div id="graph" class="w-full graph" >
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import * as Highcharts from 'highcharts';

    interface iGraph {
        array: Array<number>;
        graphType: string;
        categories: Array<string>;
    }

    @Component
    export default class DashboardChart extends Vue {
        public get Data(): iGraph {
            const array: Array<number> = [];
            const graphType = 'unknown';
            const categories = [
                "A", "B", "C", "D"
            ];

            return {
                array,
                graphType,
                categories
            } as iGraph;
        };
        mounted() {
            this.viewGraph('line');
        };
        public viewGraph(graphType: string) {
            this.Data.array = [];
            this.Data.graphType = graphType;
            for (let i = 0; i < 4; i++) {
                this.Data.array.push(Math.round(Math.random() * 100));
            }
            this.graph();
        };
        graph() {
            Highcharts.chart({
                chart: {
                    renderTo: "graph",
                    type: this.Data.graphType
                },
                credits: {
                    text: 'Rockhopper-Penguin',
                    href: 'https://github.com/rockhopper-penguin'
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
                    opposite: false
                } as Highcharts.YAxisOptions,
                series: [
                    {
                        name: "test",
                        type: this.Data.graphType,
                        data: this.Data.array
                    }
                ]
            });
        };
    }

</script>