import DashboardControls from '@/components/Dashboard/DashboardChart.vue';
import {shallowMount} from "@vue/test-utils";

const object = {
    hotel_id: 1,
    from_date: new Date('-100 days'),
    to_date: new Date('-80 days'),
};

describe("DashboardChart.vue", () => {
    let wrapper;
    beforeEach(() => {

        wrapper = shallowMount(DashboardControls, {
            methods: { fetchChart: (object) => {}}
        });
    });

    it("renders", () => {
        expect(wrapper.exist()).toBe(true);
    });

    it("chart exists", () => {
        expect(wrapper.find('.highcharts-container').exist()).toBe(true);
    });
});