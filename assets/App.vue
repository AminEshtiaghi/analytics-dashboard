<template>
    <div>
        <dashboard-controls></dashboard-controls>
        <dashboard-chart></dashboard-chart>
    </div>
</template>

<script>
    import DashboardControls from './components/Dashboard/DashboardControls.vue';
    import DashboardChart from './components/Dashboard/DashboardChart.vue';

    export default {
        components: {
            DashboardControls,
            DashboardChart,
        }
    }
</script>