const urlGroup = "http://127.0.0.1:8000/main-api/groups/";

const state = {
    groups: []
}

const getters = {
    getGroups: state => state.groups
}

const mutations = {
    setGroups(state, data) {
        state.groups = data;
    }
}

const actions = {
    getGroups(state, VueComponent) {
        VueComponent.$http.get(urlGroup + "list")
            .then(response => {
                state.commit("setGroups", response.data.groups)
            })
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
