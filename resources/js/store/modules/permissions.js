const urlPermissions = "http://127.0.0.1:8000/main-api/permissions/";


const state = {
    usersShow: false,
    usersManage: false,
    holidaysShow: false,
    holidaysManage: false,
    applicationsAdminManage: false,
    overtimesShow: false,
    overtimesManage: false,
    additionalHoursShow: false,
    additionalHoursManage: false,
    leavesManage: false,
    leavesShow: false,
    applicationsShow: false,
    applicationsManage: false,
    workdaysShow: false,
    workdaysManage: false,
    workPeriodsShow: false,
    workPeriodsManage: false,
    groupsShow: false,
    groupsManage: false,
    departmentsShow: false,
    departmentsManage: false,
    userId: 0
};

const getters = {
    getUserPermissions: state => state,
    getPermissionsUserId: state => state.userId,
    getApplicationsAdminManage: state => state.applicationsAdminManage
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
    setApplicationsAdminManage(state, data) {
        state.applicationsAdminManage = data;
    },
    setOvertimesShow(state, data) {
        state.overtimesShow = data;
    },
    setOvertimesManage(state, data) {
        state.overtimesManage = data;
    },
    setAdditionalHoursShow(state, data) {
        state.additionalHoursShow = data;
    },
    setAdditionalHoursManage(state, data) {
        state.additionalHoursManage = data;
    },
    setLeavesShow(state, data) {
        state.leavesShow = data;
    },
    setLeavesManage(state, data) {
        state.leavesManage = data;
    },
    setApplicationsShow(state, data) {
        state.applicationsShow = data;
    },
    setApplicationsManage(state, data) {
        state.applicationsManage = data;
    },
    setWorkdaysShow(state, data) {
        state.workdaysShow = data;
    },
    setWorkdaysManage(state, data) {
        state.workdaysManage = data;
    },
    setWorkPeriodsShow(state, data) {
        state.workPeriodsShow = data;
    },
    setWorkPeriodsManage(state, data) {
        state.workPeriodsManage = data;
    },
    setGroupsShow(state, data) {
        state.groupsShow = data;
    },
    setGroupsManage(state, data) {
        state.groupsManage = data;
    },
    setDepartmentsShow(state, data) {
        state.departmentsShow = data;
    },
    setDepartmentsManage(state, data) {
        state.departmentsManage = data;
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
        console.log(permissions);
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
                case 'overtimesShow':
                    state.commit("setOvertimesShow", true);
                    break;
                case 'overtimesManage':
                    state.commit("setOvertimesManage", true);
                    break;
                case 'additionalHoursShow':
                    state.commit("setAdditionalHoursShow", true);
                    break;
                case 'additionalHoursManage':
                    state.commit("setAdditionalHoursManage", true);
                    break;
                case 'leavesShow':
                    state.commit("setLeavesShow", true);
                    break;
                case 'leavesManage':
                    state.commit("setLeavesManage", true);
                    break;
                case 'applicationsShow':
                    state.commit("setApplicationsShow", true);
                    break;
                case 'applicationsManage':
                    state.commit("setApplicationsManage", true);
                    break;
                case 'workdaysShow':
                    state.commit("setWorkdaysShow", true);
                    break;
                case 'workdaysManage':
                    state.commit("setWorkdaysManage", true);
                    break;
                case 'workPeriodsShow':
                    state.commit("setWorkPeriodsShow", true);
                    break;
                case 'workPeriodsManage':
                    state.commit("setWorkPeriodsManage", true);
                    break;
                case 'groupsShow':
                    state.commit("setGroupsShow", true);
                    break;
                case 'groupsManage':
                    state.commit("setGroupsManage", true);
                    break;
                case 'departmentsShow':
                    state.commit("setDepartmentsShow", true);
                    break;
                case 'departmentsManage':
                    state.commit("setDepartmentsManage", true);
                    break;
                case 'applicationsAdminManage':
                    state.commit("setApplicationsAdminManage", true);
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