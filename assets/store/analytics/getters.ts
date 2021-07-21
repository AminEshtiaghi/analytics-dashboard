import {GetterTree} from 'vuex';
import {AnalyticsState} from "./types";
import {RootState} from "../types";
import {DataPoint} from "../../models/DataPoint";

export const getters: GetterTree<AnalyticsState, RootState> = {
    getAll(state): Array<DataPoint> {
        return state.dataPoints;
    }
};