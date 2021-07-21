import {ActionTree} from 'vuex';
import {AnalyticsState} from "./types";
import {RootState} from "../types";
import {DataPoint} from "../../models/DataPoint";
import {AnalyticsMutations} from "./mutations";
import {AnalyticsRequestData} from "../../models/AnalyticsRequestData";

export const actions: ActionTree<AnalyticsState,RootState> = {
    fetchData({commit}, payload: AnalyticsRequestData): Promise<Array<DataPoint>> {

        const hotelId = payload.hotel_id;
        const from = payload.from_date.toISOString().split('T')[0];
        const to = payload.to_date.toISOString().split('T')[0];

        return fetch(`/api/analytics?hotel_id=${hotelId}&from=${from}&to=${to}`)
        .then((response) => {
            return response.json();
        })
        .then((dataPoints: Array<DataPoint>) => {
            commit(AnalyticsMutations.SetDataPoints, dataPoints);
            return dataPoints;
        }) as Promise<Array<DataPoint>>;
    }
};