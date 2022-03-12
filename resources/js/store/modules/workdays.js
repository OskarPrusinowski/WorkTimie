const urlWorkday = "http://127.0.0.1:8000/main-api/workdays/";

const state = {
    workday: {
        id: 0,
        holiday: "",
        day: 0,
        start: 0,
        stop: 0,
        break_time: 0,
        overtime: 0,
        overtime: 0,
        user_id: 0
    },
    workdays: [],
    user_id: 0,
    date: 0
};

const getters = {
    getWorkday: state => state.workday,
    getWorkdays: state => state.workdays,
    getWorkdaysDate: state => state.date,
    getWorkdayId: state => state.workday.id,
    getWorkdayUserId: state => state.workday.user_id,
    getWorkdaysUserId: state => state.user_id,
}

const mutations = {
    setWorkday(state, data) {
        state.workday = data;
    },
    setWorkdays(state, data) {
        state.workdays = data;
    },
    setWorkdaysDate(state, data) {
        state.date = data;
    },
    setWorkdaysUserId(state, data) {
        state.user_id = data;
    },
    setWorkdayId(state, data) {
        state.workday.id = data;
    },
    setWorkdayUserId(state, data) {
        state.workday.user_id = data;
    }
}

const actions = {
    startWorkday(state, VueComponent) {
        const userId = state.getters.getWorkdayUserId;
        VueComponent.$http.post(urlWorkday + "start/" + userId)
            .then(response => {
                console.log(response);
            })
    },
    stopWorkday(state, VueComponent) {
        const id = state.getters.getWorkdayId;
        VueComponent.$http.put(urlWorkday + "stop/" + id, { workday: state.getters.getWorkday })
            .then(response => {
                console.log(response);
            })
    },
    async getWorkday(state, VueComponent) {
        const userId = state.getters.getWorkdayUserId;
        await VueComponent.$http.get(urlWorkday + "getByUser/" + userId)
            .then(response => {
                console.log(response.data);
                state.commit("setWorkday", response.data.workday[0]);
            })
    },
    async getWorkdays(state, VueComponent) {
        const userId = state.getters.getWorkdaysUserId;
        const date = state.getters.getWorkdaysDate;
        await VueComponent.$http.get(urlWorkday + "list/" + userId + "?date=" + date)
            .then(response => {
                state.commit("setWorkdays", response.data.workdays);
            })
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
