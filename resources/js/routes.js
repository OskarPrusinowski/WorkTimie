import UserList from './components/Users/list'
import MonthCalendar from "./components/MonthCalendar/main"
import Home from "./components/Home/main"

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
            path: '/*',
            component: Home
        },
    ]
}
