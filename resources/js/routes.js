import UserList from './components/Users/list'
import MonthCalendar from "./components/MonthCalendar/main"
import Home from "./components/Home/main"
import HolidaysList from "./components/Holidays/list"
import ApplicationsList from "./components/Applications/list"
import LeavesShow from "./components/Leaves/show"
import LeavesList from "./components/Leaves/list"
import UsersCalendar from "./components/UsersCalendar/list"

export default {
    mode: 'history',
    routes: [
        {
            name: "UsersList",
            path: '/users/list',
            component: UserList
        },
        {
            name: "MonthCalendar",
            path: '/monthCalendar',
            component: MonthCalendar
        },
        {
            name: "UsersCalendar",
            path: '/usersCalendar',
            component: UsersCalendar
        },
        {
            name: "HolidaysList",
            path: '/holidays/list',
            component: HolidaysList
        },
        {
            name: "ApplicationsList",
            path: '/applications/list',
            component: ApplicationsList
        },
        {
            name: "LeavesShow",
            path: '/leaves/show',
            component: LeavesShow
        },
        {
            name: "LeavesList",
            path: '/leaves/list',
            component: LeavesList
        },
        {
            name: "Home",
            path: '/*',
            component: Home
        },
    ]
}
