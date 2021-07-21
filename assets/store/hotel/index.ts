import {Module} from 'vuex';
import {RootState} from '../types';
import {HotelState} from './types';
import {mutations} from './mutations';
import {actions} from './actions';
import {getters} from "./getters";

const state: HotelState = {
    hotels: []
};

export const hotel: Module<HotelState, RootState> = {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};