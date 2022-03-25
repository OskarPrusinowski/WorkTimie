<template>
  <v-app>
    <v-card class="pa-8">
      <div
        class="home"
        style="display: inline-block"
        v-if="permissions.workdaysShow"
      >
        <router-link tag="v-btn" to="/home">
          <v-btn icon> <v-icon>mdi-home</v-icon></v-btn>
        </router-link>
      </div>
      <div
        class="monthCalendar"
        style="display: inline-block"
        v-if="permissions.workdaysShow"
      >
        <router-link to="/monthCalendar">
          <v-btn depressed color="primary"> Kalendarz miesięczny </v-btn>
        </router-link>
      </div>
      <div
        class="usersCalendar"
        style="display: inline-block"
        v-if="permissions.usersShow"
      >
        <router-link to="/usersCalendar">
          <v-btn depressed color="primary"> Lista obecności </v-btn>
        </router-link>
      </div>
      <div
        class="calendars justify-center"
        justify="center"
        style="display: inline-block; margin-left: 45px"
      >
        <applications-month-picker v-if="$route.name == 'ApplicationsList'" />
        <month-calendar-month-picker
          v-else-if="$route.name == 'MonthCalendar'"
        />
        <leaves-year-picker v-else-if="$route.name == 'LeavesList'" />
        <holidays-year-picker v-else-if="$route.name == 'HolidaysList'" />
      </div>
      <div style="float: right; display: inline-block">
        <div
          class="users"
          style="display: inline-block"
          v-if="permissions.usersShow"
        >
          <router-link to="/users/list">
            <v-btn depressed color="primary"> Pracownicy </v-btn>
          </router-link>
        </div>
        <div
          class="applications"
          style="display: inline-block"
          v-if="permissions.applicationsShow"
        >
          <router-link to="/applications/list">
            <v-btn depressed color="primary">
              <v-badge
                color="red"
                :content="applicationCounter"
                v-if="applicationCounter"
                >Wnioski</v-badge
              >
              <span v-else> Wnioski</span>
            </v-btn>
          </router-link>
        </div>
        <div
          class="leaves"
          style="display: inline-block"
          v-if="permissions.leavesManage"
        >
          <router-link to="/leaves/list">
            <v-btn depressed color="primary"> Lista urlopów </v-btn>
          </router-link>
        </div>
        <div
          class="leave"
          style="display: inline-block"
          v-if="permissions.leavesShow"
        >
          <router-link to="/leaves/show">
            <v-btn depressed color="primary"> Urlop </v-btn>
          </router-link>
        </div>
        <div
          class="holidays"
          style="display: inline-block"
          v-if="permissions.holidaysShow"
        >
          <router-link to="/holidays/list">
            <v-btn depressed color="primary"> Dni wolne </v-btn>
          </router-link>
        </div>
        <div style="display: inline-block">
          <v-btn depressed color="primary" @click="logout()"> Wyloguj </v-btn>
        </div>
      </div>

      <v-divider></v-divider>
      <router-view></router-view>
    </v-card>
  </v-app>
</template>
<script>
import store from "../store/index";
import applicationsMonthPicker from "./Applications/monthPicker.vue";
import usersCalendarMonthPicker from "./UsersCalendar/monthPicker.vue";
import monthCalendarMonthPicker from "./MonthCalendar/monthPicker.vue";
import leavesYearPicker from "./Leaves/yearPicker.vue";
import holidaysYearPicker from "./Holidays/yearPicker.vue";
export default {
  components: {
    applicationsMonthPicker,
    usersCalendarMonthPicker,
    monthCalendarMonthPicker,
    leavesYearPicker,
    holidaysYearPicker,
  },
  computed: {
    permissions() {
      return store.getters.getUserPermissions;
    },
    actualUser() {
      return store.getters.getActualUser;
    },
    applicationCounter() {
      return store.getters.getApplicationsCounter;
    },
  },
  data() {
    return {
      routeName: this.$route.name,
    };
  },
  methods: {
    logout() {
      this.$http.post("http://127.0.0.1:8000/logout").then((response) => {
        console.log(response);
      });
      store.dispatch("getActualUser", this);
      window.location.reload();
    },
    countWaitingApplications() {
      store.dispatch("getWaitingApplicationsCounter", this);
    },
  },
  async beforeCreate() {
    await store.dispatch("getActualUser", this);
    store.commit("setPermissionsUserId", store.getters.getActualUserId);
    store.dispatch("getUserPermissions", this);
  },
  created() {
    this.countWaitingApplications();
  },
};
</script>
<style scoped>
li a {
  text-decoration: none;
}
</style>
