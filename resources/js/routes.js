import UserList from './components/Users/list'
import MonthCalendar from "./components/MonthCalendar/main"
import Home from "./components/Home/main"
import HolidaysList from "./components/Holidays/list"

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
            path: '/*',
            component: Home
        },
    ]
}
