const urlDepartment = "http://127.0.0.1:8000/main-api/departments/";

const state = {
    departments: []
};

const getters = {
    getDepartments: state => state.departments
};

const mutations = {
    setDepartments(state, data) {
        state.departments = data;
    }
};

const actions = {
    async getDepartments(state, VueComponent) {
        await VueComponent.$http.get(urlDepartment + "list")
            .then(response => {
                state.commit("setDepartments", response.data.departments);
            })
    }
};


export default {
    state,
    mutations,
    actions,
    getters
}
