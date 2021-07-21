import {ActionTree} from 'vuex';
import {HotelState} from "./types";
import {RootState} from "../types";
import {Hotel} from "../../models/Hotel";

export const actions: ActionTree<HotelState,RootState> = {
    fetchHotels({commit}): Promise<Array<Hotel>> {

        return fetch('/api/hotel/all')
        .then((response) => {
            return response.json();
        })
        .then((hotels: Array<Hotel>) => {
            commit('setHotels', hotels);

            return hotels;
        });
    }
};