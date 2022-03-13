const urlPermissions = "http://127.0.0.1:8000/main-api/permissions/";


const state = {
    usersShow: false,
    usersManage: false,
    holidaysShow: false,
    holidaysManage: false,
    workdaysShow: false,
    workdaysManage: false,
    groupsShow: false,
    groupsManage: false,
    userId: 0
};

const getters = {
    getUserPermissions: state => state,
    getPermissionsUserId: state => state.userId
};

const mutations = {
    setPermissionsUserId(state, data) {
        state.userId = data;
    },
    setUsersShow(state, data) {
        state.usersShow = data;
    },
    setUsersManage(state, data) {
        state.usersManage = data;
    },
    setHolidaysShow(state, data) {
        state.holidaysShow = data;
    },
    setHolidaysManage(state, data) {
        state.holidaysManage = data;
    },
    setWorkdaysShow(state, data) {
        state.workdaysShow = data;
    },
    setWorkdaysManage(state, data) {
        state.workdaysManage = data;
    },
    setGroupsShow(state, data) {
        state.groupsShow = data;
    },
    setGroupsManage(state, data) {
        state.groupsManage = data;
    },
};

const actions = {
    getUserPermissions(state, VueComponent) {
        const id = state.getters.getPermissionsUserId;
        VueComponent.$http.get(urlPermissions + id)
            .then(response => {
                console.log(response.data.permissions);
                state.dispatch("setUserPermissions", response.data.permissions);
            })
    },
    setUserPermissions(state, permissions) {
        for (var i = 0; i < permissions.length; i++) {
            switch (permissions[i].name) {
                case 'usersShow':
                    state.commit("setUsersShow", true);
                    break;
                case 'usersManage':
                    state.commit("setUsersManage", true);
                    break;
                case 'holidaysShow':
                    state.commit("setHolidaysShow", true);
                    break;
                case 'holidaysManage':
                    state.commit("setHolidaysManage", true);
                    break;
                case 'workdaysShow':
                    state.commit("setWorkdaysShow", true);
                    break;
                case 'workdaysManage':
                    state.commit("setWorkdaysManage", true);
                    break;
                case 'groupsShow':
                    state.commit("setGroupsShow", true);
                    break;
                case 'groupsManage':
                    state.commit("setGroupsManage", true);
                    break;
            }
        }
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}