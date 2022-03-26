const urlOvertime = "http://127.0.0.1:8000/main-api/overtimes/";

const state = {
    overtime: {
        id: 0,
        minutes: 0,
        date: "",
        user_id: 0
    },
    overtimes: [],
    userId: 0
};

const getters = {
    getOvertime: state => state.overtime,
    getOvertimeId: state => state.overtime.id,
    getOvertimeMinutes: state => state.overtime.minutes,
    getOvertimeDate: state => state.overtime.date,
    getOvertimeUserId: state => state.overtime.user_id,
    getOvertimes: state => state.overtimes,
    getOvertimesUserId: state => state.userId,
};

const mutations = {
    setOvertime(state, data) {
        state.overtime = data;
    },
    setOvertimeId(state, data) {
        state.overtime.id = data;
    },
    setOvertimeMinutes(state, data) {
        state.overtime.minutes = data;
    },
    setOvertimeDate(state, data) {
        state.overtime.date = data;
    },
    setOvertimeUserId(state, data) {
        state.overtime.user_id = data;
    },
    setOvertimes(state, data) {
        state.overtimes = data;
    },
    setOvertimesUserId(state, data) {
        state.userId = data;
    },
};

const actions = {
    async getOvertimesToday(state, VueComponent) {
        const userId = state.getters.getOvertimesUserId;
        await VueComponent.$http.get(urlOvertime + "listToday/" + userId)
            .then(response => {
                state.commit("setOvertimes", response.data.overtimes);
                console.log(response.data.overtimes)
            })
    },
    async createOvertime(state, VueComponent) {
        await VueComponent.$http.post(urlOvertime + "create", { overtime: state.getters.getOvertime })
            .then(response => {
                console.log(response);
            })
    }
};


export default {
    state,
    mutations,
    actions,
    getters
}