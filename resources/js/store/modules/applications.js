const urlApplication = "http://127.0.0.1:8000/main-api/applications/";

const state = {
    application: {
        id: 0,
        type: "",
        date: "",
        first_date: "",
        second_date: "",
        comment: "",
        minutes: 60,
        acceptation_date: "",
        status: "",
        user_id: 0,
        accepted: false
    },
    acceptation_id: 0,
    applications: [],
    month: "",
    status: "",
    userName: "",
};

const getters = {
    getApplication: state => state.application,
    getApplicationId: state => state.application.id,
    getApplicationType: state => state.application.type,
    getApplicationDate: state => state.application.date,
    getApplicationFirstDate: state => state.application.first_date,
    getApplicationSecondDate: state => state.application.second_date,
    getApplicationComment: state => state.application.comment,
    getApplicationMinutes: state => state.application.minutes,
    getApplicationAcceptationDate: state => state.application.acceptation_date,
    getApplicationAcceptationStatus: state => state.application.acceptation_status,
    getApplicationUserId: state => state.application.user_id,
    getApplicationsUserName: state => state.userName,
    getApplications: state => state.applications,
    getApplicationsMonth: state => state.month,
    getApplicationsStatus: state => state.status,
    getAcceptationId: state => state.acceptation_id,
    getApplicationAccepted: state => state.application.accepted
};

const mutations = {
    setApplication(state, data) {
        state.application = data;
    },
    setApplicationId(state, data) {
        state.application.id = data;
    },
    setApplicationType(state, data) {
        state.application.type = data;
    },
    setApplicationDate(state, data) {
        state.application.date = data;
    },
    setApplicationFirstDate(state, data) {
        state.application.first_date = data;
    },
    setApplicationSecondDate(state, data) {
        state.application.second_date = data;
    },
    setApplicationComment(state, data) {
        state.application.comment = data;
    },
    setApplicationMinutes(state, data) {
        state.application.minutes = data;
    },
    setApplicationAcceptationDate(state, data) {
        state.application.acceptation_date = data;
    },
    setApplicationAcceptationStatus(state, data) {
        state.application.acceptation_status = data;
    },
    setApplicationUserId(state, data) {
        state.application.user_id = data;
    },
    setApplications(state, data) {
        state.applications = data;
    },
    setAcceptationId(state, data) {
        state.acceptation_id = data;
    },
    setApplicationAccepted(state, data) {
        state.application.accepted = data;
    },
    setApplicationsMonth(state, data) {
        state.month = data;
    },
    setApplicationsStatus(state, data) {
        state.status = data;
    },
    setApplicationsUserName(state, data) {
        state.userName = data;
    },
};

const actions = {
    getApplication(state, VueComponent) {
        const id = state.getters.getApplicationId;
        VueComponent.$http.get(urlApplication + "show/" + id)
            .then(response => {
                state.commit("setApplication", response.data.application);
            })
    },
    getApplications(state, VueComponent) {
        const month = state.getters.getApplicationsMonth;
        const status = state.getters.getApplicationsStatus;
        const userName = state.getters.getApplicationsUserName;
        VueComponent.$http.get(urlApplication + "list?month=" + month + "&status=" + status + "&userName=" + userName)
            .then(response => {
                state.commit("setApplications", response.data.applications);
                console.log(response.data.applications)
            })
    },
    createApplication(state, VueComponent) {
        VueComponent.$http.post(urlApplication + "create", { application: state.getters.getApplication })
            .then(response => {
                console.log(response);
            })
    },
    updateApplication(state, VueComponent) {
        const id = state.getters.getApplicationId;
        VueComponent.$http.put(urlApplication + "update/" + id, { application: state.getters.getApplication })
            .then(response => {
                console.log(response)
            })
    },
    considerApplcation(state, VueComponent) {
        const id = state.getters.getApplicationId;
        const acceptationId = state.getters.getAcceptationId;
        const accepted = state.getters.getApplicationAccepted;
        VueComponent.$http.put(urlApplication + "consider/" + id + "?acceptationId=" + acceptationId + "&accepted=" + accepted)
            .then(response => {
                console.log(response);
            })
    },
    fetchApplicationInit(state) {
        state.commit("setApplicationMinutes", 60)
        state.commit("setApplicationComment", "")
        state.commit("setApplicationFirstDate", "");
        state.commit("setApplicationSecondDate", "");
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}
