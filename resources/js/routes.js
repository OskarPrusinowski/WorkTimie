import UserList from './components/Users/list'
import MonthCalendar from "./components/MonthCalendar/main"
import Home from "./components/Home/main"
import HolidaysList from "./components/Holidays/list"
import ApplicationsList from "./components/Applications/list"

export default {
    mode: 'history',
    routes: [
        {
            path: '/users/list',
            component: UserList
        },
        {
            path: '/monthCalendar',
            component: MonthCalendar
        },
        {
            path: '/holidays/list',
            component: HolidaysList
        },
        {
            path: '/applications/list',
            component: ApplicationsList
        },
        {
            path: '/*',
            component: Home
        },
    ]
}
