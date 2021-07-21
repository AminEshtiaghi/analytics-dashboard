<template>
    <div class="flex flex-wrap my-6">
        <div class="w-full lg:w-1/3 mb-6 px-2 md:mb-0">
            <label for="hotel" >Hotel</label>
            <div v-if="!isLoading" class="inline-block relative w-full">
                <select id="hotel"
                        v-model="hotel_id.value"
                        :class="{'border-gray-400 hover:border-gray-500': hotel_id.validate, 'border-red-400 hover:border-red-500': !hotel_id.validate}"
                        class="block appearance-none w-full bg-white border mt-2 px-4 py-3 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="0" selected>Select one of Hotels</option>
                    <option v-for="hotelItem in allHotels" :key="hotelItem.id" :value="hotelItem.id">{{hotelItem.name}}</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
            <p v-if="!isLoading && !hotel_id.validate" class="text-red-500 text-xs italic mt-2">{{hotel_id.message}}</p>
            <div v-if="isLoading" class="inline-block relative w-full">
                <input type="text"
                       value="Hotels data are loading..."
                       class="appearance-none block w-full bg-gray-300 text-gray-700 border border-gray-500 rounded mt-2 py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-blue-100"
                       disabled>
            </div>
        </div>
        <div class="w-full lg:w-1/3 mb-6 px-2 md:mb-0">
            <label for="from" >From</label>
            <datetime id="from" v-model="from_date.value"
                      format="yyyy-MM-dd"
                class="appearance-none block w-full bg-white text-gray-700 border border-gray-500 rounded mt-2 py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-blue-100">
            </datetime>
            <p v-if="!from_date.validate" class="text-red-500 text-xs italic mt-2">{{from_date.message}}</p>
        </div>
        <div class="w-full lg:w-1/3 mb-6 px-2 md:mb-0">
            <label for="to" >To</label>
            <datetime id="to" v-model="to_date.value"
                      format="yyyy-MM-dd"
                      class="appearance-none block w-full bg-white text-gray-700 border border-gray-500 rounded mt-2 py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-blue-100">
            </datetime>
            <p v-if="!to_date.validate" class="text-red-500 text-xs italic mt-2">{{to_date.message}}</p>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue, Watch, Emit } from 'vue-property-decorator';

    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css';
    import {Hotel} from "../../models/Hotel";
    import {AnalyticsRequestData} from "../../models/AnalyticsRequestData";

    interface iNumber {
        value: number;
        validate: boolean;
        message: string|null;
    }

    interface iString {
        value: string;
        validate: boolean;
        message: string|null;
    }

    @Component({
        components: {
            'datetime': Datetime
        }
    })
    export default class DashboardControls extends Vue {
        public hotel_id: iNumber = {
            value: 0,
            validate: true,
            message: null
        };
        public from_date: iString = {
            value: new Date('2020-01-01T05:00:00.000').toISOString(),
            validate: true,
            message: null
        };
        public to_date: iString = {
            value: new Date('2020-04-31T05:00:00.000').toISOString(),
            validate: true,
            message: null
        };
        public hotels: Array<Hotel> = [];
        public isLoading: boolean = false;
        mounted() {
            this.getAll();
        };
        get allHotels(): Array<Hotel> {
            return this.$store.getters['hotel/getAll'];
        };
        @Watch('hotel_id.value')
        hotelIdChange(newValue: number|null, oldValue: number|null) {
            if (newValue !== oldValue) {
                this.requestChart();
            }
        };
        @Watch('from_date.value')
        fromDateChange(newValue: string|null, oldValue: string|null) {
            if (newValue !== oldValue) {
                this.requestChart();
            }
        };
        @Watch('to_date.value')
        toDateChange(newValue: string|null, oldValue: string|null) {
            if (newValue !== oldValue) {
                this.requestChart();
            }
        };
        private validate(): boolean {
            let validation: boolean = true;

            this.hotel_id.validate = true;
            this.hotel_id.message = null;

            this.from_date.validate = true;
            this.from_date.message = null;

            this.to_date.validate = true;
            this.to_date.message = null;

            if (this.hotel_id.value === null || this.hotel_id.value == 0) {
                this.hotel_id.validate = false;
                this.hotel_id.message = 'Please select one of hotels!';
                validation = false;
            }

            if (this.from_date.value === null) {
                this.from_date.validate = false;
                this.from_date.message = 'Please pick start date of the report!';
                validation = false;
            }

            if (this.to_date.value === null) {
                this.to_date.validate = false;
                this.to_date.message = 'Please pick end date of the report!';
                validation = false;
            }

            if (this.from_date.value !== null && this.to_date.value !== null) {

                if (new Date(this.from_date.value) > new Date(this.to_date.value)) {
                    this.to_date.validate = false;
                    this.to_date.message = 'The end bound of the report should be greater than start date!';
                    validation = false;
                }

            }

            return validation;
        };
        private requestChart(): void {
            if (!this.validate()) {
                return;
            }

            this.drawChart();
        };
        @Emit('fetch-chart')
        public drawChart() :AnalyticsRequestData {
            return {
                hotel_id: this.hotel_id.value,
                from_date: new Date(this.from_date.value),
                to_date: new Date(this.to_date.value)
            };
        };
        private getAll(): void {

            this.isLoading = true;

            this.$store.dispatch('hotel/fetchHotels')
            .then((hotels: Array<Hotel>) => {
                this.hotels = hotels;
                this.isLoading = false;
            });

        }
    }
</script>