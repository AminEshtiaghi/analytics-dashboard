import {MutationTree} from 'vuex';
import {AnalyticsState} from "./types";
import {DataPoint} from "../../models/DataPoint";

export enum AnalyticsMutations {
    SetDataPoints = "SetDataPoints",
}

export const mutations: MutationTree<AnalyticsState> = {
    [AnalyticsMutations.SetDataPoints](state, payload: Array<DataPoint>) {
        state.dataPoints = payload;
    }
};