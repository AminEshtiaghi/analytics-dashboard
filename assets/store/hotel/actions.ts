import {ActionTree} from 'vuex';
import {HotelState} from "./types";
import {RootState} from "../types";
import {Hotel} from "../../models/Hotel";

export const actions: ActionTree<HotelState,RootState> = {
    fetchHotels({commit, getters}): void {

        const allHotels: Array<Hotel> = getters['getAll'];
        if (allHotels.length > 0) {
            return;
        }

        fetch('/api/hotel/all')
        .then((response) => {
            return response.json();
        })
        .then((hotels: Array<Hotel>) => {
            commit('setHotels', hotels);
        });
    }
};