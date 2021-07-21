import Vue from 'vue';
import Vuex, {StoreOptions} from 'vuex';
import {RootState} from './types';
import {hotel} from './hotel';

// import Hotel from './hotel';
Vue.use(Vuex);

// const store = new Vuex.Store({
//     modules: {
//         Hotel
//     }
// });

const store: StoreOptions<RootState> = {
    state: {},
    modules: {
        hotel
    }
};

export default new Vuex.Store<RootState>(store);
