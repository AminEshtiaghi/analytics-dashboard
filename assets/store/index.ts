import Vue from 'vue';
import Vuex, {StoreOptions} from 'vuex';
import {RootState} from './types';
import {hotel} from './hotel';
import {analytics} from './analytics';

Vue.use(Vuex);

const store: StoreOptions<RootState> = {
    state: {},
    modules: {
        hotel,
        analytics
    }
};

export default new Vuex.Store<RootState>(store);
