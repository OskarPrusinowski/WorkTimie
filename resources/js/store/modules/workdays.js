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
    }

};

const getters = {
    getWorkday: state => state.workday,
    getWorkdayId: state => state.workday.id,
    getWorkdayUserId: state => state.workday.user_id,
}

const mutations = {
    setWorkday(state, data) {
        state.workday = data;
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
        const userId = state.getters.getWorkdayUserId;
        console.log(state.getters.getWorkday);
        console.log(state.getters.getWorkday.user_id);
        VueComponent.$http.put(urlWorkday + "stop/" + userId, { workday: state.getters.getWorkday })
            .then(response => {
                console.log(response);
            })
    },
    async getActualWorkday(state, VueComponent) {
        const userId = state.getters.getWorkdayUserId;
        await VueComponent.$http.get(urlWorkday + "getByUser/" + userId)
            .then(response => {
                console.log(response.data);
                state.commit("setWorkday", response.data.workday[0]);
            })
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
