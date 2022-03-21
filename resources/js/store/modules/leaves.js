const urlLeave = "http://127.0.0.1:8000/main-api/leaves/";

const state = {
    leave: {
        id: 0,
        name: "",
        start: "",
        end: "",
        user_id: 0,
    },
    leaves: [],
    userId: 0,
    date: "",
    userName: ""
};

const getters = {
    getLeave: state => state.leave,
    getLeaveId: state => state.leave.id,
    getLeaveName: state => state.leave.name,
    getLeaveStart: state => state.leave.start,
    getLeaveEnd: state => state.leave.end,
    getLeaveUserId: state => state.leave.user_id,
    getLeaves: state => state.leaves,
    getLeavesUserId: state => state.userId,
    getLeavesDate: state => state.date,
    getLeavesUserName: state => state.userName,
};

const mutations = {
    setLeave(state, data) {
        state.leave = data;
    },
    setLeaveId(state, data) {
        state.leave.id = data;
    },
    setLeaveName(state, data) {
        state.leave.name = data;
    },
    setLeaveStart(state, data) {
        state.leave.start = data;
    },
    setLeaveEnd(state, data) {
        state.leave.end = data;
    },
    setLeaveUserId(state, data) {
        state.leave.user_id = data;
    },
    setLeaves(state, data) {
        state.leaves = data;
    },
    setLeavesUserId(state, data) {
        state.userId = data;
    },
    setLeavesDate(state, data) {
        state.date = data
    },
    setLeavesUserName(state, data) {
        state.userName = data;
    }
};

const actions = {
    getLeavesByUser(state, VueComponent) {
        const userId = state.getters.getLeavesUserId;
        VueComponent.$http.get(urlLeave + "listByUser/" + userId)
            .then(response => {
                state.commit("setLeaves", response.data.leaves)
            })
    },
    createLeave(state, VueComponent) {
        VueComponent.$http.post(urlLeave + "create", { leave: state.getters.getLeave })
            .then(response => {
                console.log(response)
            })
    },
    getLeaves(state, VueComponent) {
        const date = state.getters.getLeavesDate;
        const userName = state.getters.getLeavesUserName;
        VueComponent.$http.get(urlLeave + "listByDate?date=" + date + "&userName=" + userName)
            .then(response => {
                state.commit("setLeaves", response.data.leaves)
            })
    },
};

export default {
    state,
    mutations,
    actions,
    getters
}
