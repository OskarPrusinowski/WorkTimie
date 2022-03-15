const urlApplication = "http://127.0.0.1:8000/main-api/applications/";

const state = {
    application: {
        id: 0,
        type: "",
        date: "",
        changed_date: "",
        comment: "",
        minutes: 0,
        acceptation_date: "",
        status: "",
        user_id: 0,
        accepted: false
    },
    acceptation_id: 0,
    applications: [],
};

const getters = {
    getApplication: state => state.application,
    getApplicationId: state => state.application.id,
    getApplicationType: state => state.application.type,
    getApplicationDate: state => state.application.date,
    getApplicationChangedDate: state => state.application.changed_date,
    getApplicationComment: state => state.application.comment,
    getApplicationMinutes: state => state.application.minutes,
    getApplicationAcceptationDate: state => state.application.acceptation_date,
    getApplicationAcceptationStatus: state => state.application.acceptation_status,
    getApplicationUserId: state => state.application.user_id,
    getApplications: state => state.applications,
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
    setApplicationChangedDate(state, data) {
        state.application.changed_date = data;
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
    }
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
        VueComponent.$http.get(urlApplication + "list")
            .then(response => {
                state.commit("setApplications", response.data.applications);
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
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}