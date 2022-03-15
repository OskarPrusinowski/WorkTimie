const urlAdditionalHours = "http://127.0.0.1:8000/main-api/additionalhours/";

const state = {
    additionalHour: {
        id: 0,
        minutes: 0,
        date: "",
        user_id: 0
    },
    additionalHours: []
};

const getters = {
    getAdditionalHour: state => state.additionalHour,
    getAdditionalHourId: state => state.additionalHour.id,
    getAdditionalHourMinutes: state => state.additionalHour.minutes,
    getAdditionalHourDate: state => state.additionalHour.date,
    getAdditionalHourUserId: state => state.additionalHour.user_id,
    getAdditionalHours: state => state.additionalHours,
};

const mutations = {
    setAdditionalHour(state, data) {
        state.additionalHour = data;
    },
    setAdditionalHourId(state, data) {
        state.additionalHour.id = data;
    },
    setAdditionalHourMinutes(state, data) {
        state.additionalHour.minutes = data;
    },
    setAdditionalHourDate(state, data) {
        state.additionalHour.date = data;
    },
    setAdditionalHourUserId(state, data) {
        state.additionalHour.user_id = data;
    },
    setAdditionalHours(state, data) {
        state.additionalHours = data
    }
};

const actions = {
    async getAdditionalHoursByUser(state, VueComponent) {
        const user_id = state.getters.getAdditionalHourUserId;
        await VueComponent.$http.get(urlAdditionalHours + "listByUser/" + user_id)
            .then(response => {
                state.commit("setAdditionalHours", response.data.additionalHours);
            })
    },

    createAdditionalHour(state, VueComponent) {
        console.log(state.getters.getAdditionalHour);
        VueComponent.$http.post(urlAdditionalHours + "create", { additionalHour: state.getters.getAdditionalHour })
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