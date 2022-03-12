const urlWorkPeriods = "http://127.0.0.1:8000/main-api/workPeriods/";

const state = {
    workPeriod: {
        id: 0,
        type: "",
        start: 0,
        stop: 0,
        workday_id: 0,
    }
}

const getters = {
    getWorkPeriod: state => state.workPeriod,
    getWorkPeriodId: state => state.workPeriod.id,
    getWorkPeriodWorkdayId: state => state.workPeriod.workday_id,
    getWorkPeriodType: state => state.workPeriod.type
}

const mutations = {
    setWorkPeriod(state, data) {
        state.workPeriod = data;
    },
    setWorkPeriodId(state, data) {
        state.workPeriod.id = data;
    },
    setWorkPeriodWorkdayId(state, data) {
        state.workPeriod.workday_id = data;
    },
    setWorkPeriodType(state, data) {
        state.workPeriod.type = data;
    }
}

const actions = {
    startWorkPeriod(state, VueComponent) {
        const workday_id = state.getters.getWorkPeriodWorkdayId;
        VueComponent.$http.post(urlWorkPeriods + "start/" + workday_id, { type: state.getters.getWorkPeriodType })
            .then(response => {
                console.log(response);
                state.commit("setWorkPeriod", response.data.workPeriod);
            })
    },
    stopWorkPeriod(state, VueComponent) {
        const id = state.getters.getWorkPeriodId;
        VueComponent.$http.put(urlWorkPeriods + "stop/" + id, { workPeriod: state.getters.getWorkPeriod })
            .then(response => {
                console.log(response);
            })
    },
    getLastWorkPeriod(state, VueComponent) {
        const workday_id = state.getters.getWorkPeriodWorkdayId;
        VueComponent.$http.get(urlWorkPeriods + "getLastWorkPeriod/" + workday_id)
            .then(response => {
                state.commit("setWorkPeriod", response.data.workPeriod);
            })
    }
}


export default {
    state,
    mutations,
    actions,
    getters
}
