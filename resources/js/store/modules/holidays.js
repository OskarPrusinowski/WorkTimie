const urlHolidays = "http://127.0.0.1:8000/main-api/holidays/";

const state = {
    holidays: [],
    holiday: {
        id: null,
        name: "",
        day: "",
        date: ""
    },
    date: ""
};

const getters = {
    getHolidays: state => state.holidays,
    getHoliday: state => state.holiday,
    getHolidayId: state => state.holiday.id,
    getHolidayName: state => state.holiday.name,
    getHolidayDay: state => state.holiday.day,
    getHolidayDate: state => state.holiday.date,
    getHolidaysDate: state => state.date,
};

const mutations = {
    setHolidays(state, data) {
        state.holidays = data;
    },
    setHoliday(state, data) {
        state.holiday = data;
    },
    setHolidayId(state, data) {
        state.holiday.id = data;
    },
    setHolidayName(state, data) {
        state.holiday.name = data;
    },
    setHolidayDay(state, data) {
        state.holiday.day = data;
    },
    setHolidayDate(state, data) {
        state.holiday.date = data;
    },
    setHolidaysDate(state, data) {
        state.date = data;
    }
};

const actions = {
    getHolidays(state, VueComponent) {
        const date = state.getters.getHolidaysDate;
        VueComponent.$http.get(urlHolidays + "list?date=" + date)
            .then(response => {
                state.commit("setHolidays", response.data.holidays);
            })
    },
    createHoliday(state, VueComponent) {
        VueComponent.$http.post(urlHolidays + "create", { holiday: state.getters.getHoliday })
            .then(response => {
                console.log(response);
            })
    },
    deleteHoliday(state, VueComponent) {
        const id = state.getters.getHolidayId;
        VueComponent.$http.delete(urlHolidays + "delete/" + id)
            .then(response => {
                console.log(response);
            })
    },
    setHolidayInit(state) {
        state.commit("setHolidayId", null);
        state.commit("setHolidayName", "");
        state.commit("setHolidayDay", "");
        state.commit("setHolidayDate", "");
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}
