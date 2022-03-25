const urlUser = "http://127.0.0.1:8000/main-api/users/";

const state = {
    user: {
        id: null,
        name: "",
        surname: "",
        phone_number: 0,
        email: "",
        counter_holidays: 0,
        current_counter_holidays: 0,
        date_start_employment: "",
        date_stop_employment: "",
        password: "",
        group_id: 1,
        department_id: 1
    },
    users: [],
    date: "",
    start: "",
    stop: "",
    name: "",
    department_id: 0
};

const getters = {
    getUser: state => state.user,
    getUserId: state => state.user.id,
    getUserName: state => state.user.name,
    getUserSurname: state => state.user.surname,
    getUserPhoneNumber: state => state.user.phone_number,
    getUserEmail: state => state.user.email,
    getUserCounterHolidays: state => state.users.counter_holidays,
    getUserCurrentCounterHolidays: state => state.users.current_counter_holidays,
    getUserDateStartEmployed: state => state.user.date_start_employment,
    getUserDateStopEmployed: state => state.user.date_stop_employment,
    getActualUserGroupId: state => state.user.group_id,
    getUserPassword: state => state.user.password,
    getUserGroupId: state => state.user.group_id,
    getUsers: state => state.users,
    getUsersName: state => state.name,
    getUsersDate: state => state.date,
    getUsersStart: state => state.start,
    getUsersStop: state => state.stop,
    getUsersDepartmentId: state => state.department_id,
};

const mutations = {
    setUser(state, data) {
        state.user = data;
    },
    setUserId(state, data) {
        state.user.id = data;
    },
    setUserName(state, data) {
        state.user.name = data;
    },
    setUserSurname(state, data) {
        state.user.surname = data;
    },
    setUserPhoneNumber(state, data) {
        state.user.phone_number = data;
    },
    setUserEmail(state, data) {
        state.user.email = data;
    },
    setUserDateStartEmployment(state, data) {
        state.user.date_start_employment = data;
    },
    setUserDateStopEmployment(state, data) {
        state.user.date_stop_employment = data;
    },
    setUserPassword(state, data) {
        state.user.password = data;
    },
    setUserGroupId(state, data) {
        state.user.group_id = data;
    },
    setUserDepartmentId(state, data) {
        state.user.department_id = data;
    },
    setUserCounterHolidays(state, data) {
        state.user.counter_holidays = data;
    },
    setUserCurrentCounterHolidays(state, data) {
        state.user.current_counter_holidays = data;
    },
    setUsers(state, data) {
        state.users = data;
    },
    setUsersName(state, data) {
        state.name = data;
    },
    setUsersDate(state, data) {
        state.date = data;
    },
    setUsersStart(state, data) {
        state.start = data;
    },
    setUsersStop(state, data) {
        state.stop = data;
    },
    setUsersDepartmentId(state, data) {
        state.department_id = data
    },
};

const actions = {
    getUsers(state, VueComponent) {
        const name = state.getters.getUsersName;
        const departmentId = state.getters.getUsersDepartmentId;
        VueComponent.$http.get(urlUser + "list?name=" + name + "&departmentId=" + departmentId)
            .then(response => {
                state.commit("setUsers", response.data.users);
            })
    },
    getUsersByDatesName(state, VueComponent) {
        const start = state.getters.getUsersStart;
        const stop = state.getters.getUsersStop;
        const name = state.getters.getUsersName;
        VueComponent.$http.get(urlUser + "listWithFiltr?start=" + start + "&stop=" + stop + "&name=" + name)
            .then(response => {
                state.commit("setUsers", response.data.users);
            })
    },
    deleteUser(state, VueComponent) {
        const id = state.getters.getUserId;
        VueComponent.$http.delete(urlUser + "delete/" + id)
            .then(response => {
                console.log(response);
            })
    },
    createUser(state, VueComponent) {
        console.log(state.getters.getUser);
        VueComponent.$http.post(urlUser + "create", { user: state.getters.getUser })
            .then(response => {
                console.log(response);
            })
    },
    updateUser(state, VueComponent) {
        const id = state.getters.getUserId;
        VueComponent.$http.put(urlUser + "update/" + id, { user: state.getters.getUser })
            .then(response => {
                console.log(response);
            })
    },
    fetchUserInit(state) {
        state.commit("setUserId", null);
        state.commit("setUserName", "");
        state.commit("setUserSurname", "");
        state.commit("setUserEmail", "");
        state.commit("setUserPhoneNumber", 0);
        state.commit("setUserDateStartEmployment", "");
        state.commit("setUserDateStopEmployment", "");
        state.commit("setUserPassword", "");
        state.commit("setUserGroupId", 1);
        state.commit("setUserDepartmentId", 1);
    },
    getUsersLeaves(state, VueComponent) {
        const date = state.getters.getUsersDate;
        const name = state.getters.getUsersName;
        const departmentId = state.getters.getUsersDepartmentId;
        VueComponent.$http.get(urlUser + "listLeaves?date=" + date + "&name=" + name + "&departmentId=" + departmentId)
            .then(response => {
                state.commit("setUsers", response.data.users);
            })
    },
    increaseCounterHolidays(state, VueComponent) {
        VueComponent.$http.put(urlUser + 'increaseCounterHolidays')
            .then(response => {
                console.log(response);
            })
    },
    updateHolidaysCounter(state, VueComponent) {
        const id = state.getters.getUserId;
        VueComponent.$http.put(urlUser + "updateHolidaysCounter/" + id)
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
