import {GetterTree} from 'vuex';
import {HotelState} from "./types";
import {RootState} from "../types";
import {Hotel} from "../../models/Hotel";

export const getters: GetterTree<HotelState, RootState> = {
    getAll(state): Array<Hotel> {
        return state.hotels;
    }
};