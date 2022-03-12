const urlUser = "http://127.0.0.1:8000/main-api/users/";

const state = {
    user: {
        id: null,
        name: "",
        surname: "",
        phone_number: 0,
        email: "",
        date_start_employment: "",
        date_stop_employment: "",
        password: "",
        group_id: 1,
    },
    users: []
};

const getters = {
    getUser: state => state.user,
    getUserId: state => state.user.id,
    getUserName: state => state.user.name,
    getUserSurname: state => state.user.surname,
    getUserPhoneNumber: state => state.user.phone_number,
    getUserEmail: state => state.user.email,
    getUserDateStartEmployed: state => state.user.date_start_employment,
    getUserDateStopEmployed: state => state.user.date_stop_employment,
    getUserPassword: state => state.user.password,
    getUserGroupId: state => state.user.group_id,
    getUsers: state => state.users
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
    setUsers(state, data) {
        state.users = data;
    }
};

const actions = {
    getUsers(state, VueComponent) {
        VueComponent.$http.get(urlUser + "list")
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
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}
