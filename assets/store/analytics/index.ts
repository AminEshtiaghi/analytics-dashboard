import {Module} from 'vuex';
import {RootState} from '../types';
import {AnalyticsState} from './types';
import {mutations} from './mutations';
import {actions} from './actions';
import {getters} from "./getters";

const state: AnalyticsState = {
    dataPoints: []
};

export const analytics: Module<AnalyticsState, RootState> = {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};