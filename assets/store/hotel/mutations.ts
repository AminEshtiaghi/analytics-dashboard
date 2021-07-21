import {MutationTree} from 'vuex';
import {HotelState} from "./types";
import {Hotel} from "../../models/Hotel";

export const mutations: MutationTree<HotelState> = {
    setHotels(state, payload: Array<Hotel>) {
        state.hotels = payload;
    }
};