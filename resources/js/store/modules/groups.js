const urlGroup = "http://127.0.0.1:8000/main-api/groups/";

const state = {
    groups: [],
    group: {
        id: 0,
        name: "",
        worktime: 0
    }
}

const getters = {
    getGroups: state => state.groups,
    getGroup: state => state.group,
    getGroupId: state => state.group.id,
    getGroupWorktime: state => state.group.worktime,
}

const mutations = {
    setGroups(state, data) {
        state.groups = data;
    },
    setGroup(state, data) {
        state.group = data;
    },
    setGroupId(state, data) {
        state.group.id = data;
    },
}

const actions = {
    getGroups(state, VueComponent) {
        VueComponent.$http.get(urlGroup + "list")
            .then(response => {
                state.commit("setGroups", response.data.groups)
            })
    },
    getGroup(state, VueComponent) {
        const id = state.getters.getGroupId;
        VueComponent.$http.get(urlGroup + "show/" + id)
            .then(response => {
                state.commit("setGroup", response.data.group)
            })
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
