import Vue from 'vue'
import Vuex from 'vuex'
import users from './modules/users'
import groups from './modules/groups'
import actualUser from './modules/actualUser'
import workdays from './modules/workdays'
import workPeriods from './modules/workPeriods'
import permissions from './modules/permissions'
import holidays from './modules/holidays'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        users,
        groups,
        actualUser,
        workdays,
        workPeriods,
        permissions,
        holidays
    },
})
