import DashboardControls from '@/components/Dashboard/DashboardControls.vue';
import {shallowMount} from "@vue/test-utils";

describe("DashboardControls.vue", () => {
    let wrapper;
    beforeEach(() => {
        wrapper = shallowMount(DashboardControls, {
            methods: { getAll: () => {}}
        });
    });

    it("renders", () => {
        expect(wrapper.exist()).toBe(true);
    });

    it("elements exists", () => {
        expect(wrapper.find('input').count()).toEqual(2);
        expect(wrapper.find('select').count()).toEqual(1);
    });

    it("hotels are loaded", () => {
        expect(wrapper.vm.$data.hotels.length).toEqual(10);
    });
});