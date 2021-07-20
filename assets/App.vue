<template>
    <div class="w-full">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <dashboard-controls></dashboard-controls>
            <dashboard-chart></dashboard-chart>
        </div>
        <p class="text-center text-gray-500 text-xs">
            Eshtiaghi.Amin@gmail.com &copy;2021 Analytics Code Challenge.
        </p>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    import DashboardControls from './components/Dashboard/DashboardControls.vue';
    import DashboardChart from './components/Dashboard/DashboardChart.vue';

    @Component({
        components: {
            DashboardControls,
            DashboardChart,
        }
    })
    export default class App extends Vue {

    }
</script>