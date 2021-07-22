import DashboardControls from '@/components/Dashboard/DashboardChart.vue';
import {shallowMount} from "@vue/test-utils";


let fromDate = new Date();
let toDate = new Date();
const inputConstructor = {
    hotel_id: 1,
    from_date: fromDate.setDate(fromDate.getDate()-100),
    to_date: toDate.setDate(toDate.getDate()-80),
};

describe("DashboardChart.vue", () => {
    let wrapper;
    beforeEach(() => {

        wrapper = shallowMount(DashboardControls, {
            methods: { fetchChart: (inputConstructor) => {}}
        });
    });

    it("renders", () => {
        expect(wrapper.exist()).toBe(true);
    });

    it("chart exists", () => {
        expect(wrapper.find('.highcharts-container').exist()).toBe(true);
    });
});