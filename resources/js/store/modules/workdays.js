const urlWorkday = "http://127.0.0.1:8000/main-api/workdays/";

const state = {
    workday: {
        id: 0,
        holiday: "",
        day: "",
        start: "",
        stop: "",
        breaktime: 0,
        worktime: 0,
        overtime: 0,
        additional_hours: 0,
        default_worktime: 0,
        user_id: 0
    },
    workdays: [],
    user_id: 0,
    date: "",
    minutes: 0,
    type: 0
};

const getters = {
    getWorkday: state => state.workday,
    getWorkdays: state => state.workdays,
    getWorkdaysDate: state => state.date,
    getWorkdayId: state => state.workday.id,
    getWorkdayUserId: state => state.workday.user_id,
    getWorkdaysUserId: state => state.user_id,
    getWorkdaysMinutes: state => state.minutes,
    getWorkdaysType: state => state.type,
    getWorkdayBreaktime: state => state.workday.breaktime,
    getWorkdayDefaultWorktime: state => state.workday.default_worktime,
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
    },
    setWorkdayBreaktime(state, data) {
        state.workday.breaktime = data;
    },
    setWorkdaysType(state, data) {
        state.type = data;
    },
    setWorkdaysMinutes(state, data) {
        state.minutes = data;
    },
    setWorkdayDefaultWorktime(state, data) {
        state.workday.default_worktime = data;
    }
}

const actions = {
    startWorkday(state, VueComponent) {
        const userId = state.getters.getWorkdayUserId;
        const defaultWorktime = state.getters.getWorkdayDefaultWorktime;
        VueComponent.$http.put(urlWorkday + "start", { userId: userId, defaultWorktime: defaultWorktime })
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
                state.commit("setWorkday", response.data.workday);
            })
    },
    async getWorkdays(state, VueComponent) {
        const userId = state.getters.getWorkdaysUserId;
        const date = state.getters.getWorkdaysDate;
        await VueComponent.$http.get(urlWorkday + "list/" + userId + "?date=" + date)
            .then(response => {
                state.commit("setWorkdays", response.data.workdays);
            })
    },
    updateWorkday(state, VueComponent) {
        const id = state.getters.getWorkdayId;
        VueComponent.$http.put(urlWorkday + "update/" + id, { workday: state.getters.getWorkday })
            .then(response => {
                console.log(response);
            })
    },
    addTimeWorkday(state, VueComponent) {
        const userId = state.getters.getWorkdaysUserId;
        const minutes = state.getters.getWorkdaysMinutes;
        const type = state.getters.getWorkdaysType;
        VueComponent.$http.put(urlWorkday + "add/" + userId + "?minutes=" + minutes + "&type=" + type)
            .then(response => {
                console.log(response)
            })
    },
    getAnotherWorkdays(state, VueComponent) {
        const userId = state.getters.getWorkdaysUserId;
        VueComponent.$http.get(urlWorkday + "listAnother/" + userId)
            .then(response => {
                state.commit("setWorkdays", response.data.workdays);
                console.log(state.getters.getWorkdays)
            })
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
