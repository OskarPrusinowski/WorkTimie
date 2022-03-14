const urlHolidays = "http://127.0.0.1:8000/main-api/holidays/";

const state = {
    holidays: [],
    holiday: {
        id: null,
        name: "",
        day: "",
        date: ""
    },
    date: "",
    freeSaturdays: [],
    freeSaturdayId: 0,
    freeSaturdayFree: 0
};

const getters = {
    getHolidays: state => state.holidays,
    getHoliday: state => state.holiday,
    getHolidayId: state => state.holiday.id,
    getHolidayName: state => state.holiday.name,
    getHolidayDay: state => state.holiday.day,
    getHolidayDate: state => state.holiday.date,
    getHolidaysDate: state => state.date,
    getHolidaysFreeSaturdays: state => state.freeSaturdays,
    getHolidaysFreeSaturdayId: state => state.freeSaturdayId,
    getHolidaysFreeSaturdayFree: state => state.freeSaturdayFree
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
    },
    setHolidaysFreeSaturdays(state, data) {
        state.freeSaturdays = data;
    },

    setHolidaysFreeSaturdayId(state, data) {
        state.freeSaturdayId = data;
    },
    setHolidaysFreeSaturdayFree(state, data) {
        state.freeSaturdayFree = data;
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
    },
    setHolidaysFreeSaturdays(state, VueComponent) {
        const date = state.getters.getHolidaysDate;
        const freeSaturday = state.getters.getHolidaysFreeSaturdayFree;
        VueComponent.$http.post(urlHolidays + "freeSaturdays?date=" + date + "&freeSaturday=" + freeSaturday)
            .then(response => {
                console.log(response);
            })
    },
    getHolidaysFreeSaturdays(state, VueComponent) {
        VueComponent.$http.get(urlHolidays + "freeSaturdays/list")
            .then(response => {
                console.log(response);
                state.commit("setHolidaysFreeSaturdays", response.data.freeSaturdays)
            })
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}
