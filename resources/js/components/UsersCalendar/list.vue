<template>
  <div v-if="permissions.usersShow">
    <filtr-field @changedName="getUsers()" />
    <week-picker @changedDates="getUsers()" />
    <v-divider />
    <v-simple-table v-if="users.length > 0">
      <thead>
        <tr>
          <th>Osoba</th>
          <th v-for="workday in users[0].workdays" :key="workday.id">
            {{ workday.date }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }} {{ user.surname }}</td>
          <td v-for="workday in user.workdays" :key="workday.id">
            <div
              v-if="workday.holiday"
              class="pa-5 ma-1 rounded-circle d-inline-block grey"
            ></div>
            <div
              v-else-if="workday.stop"
              class="pa-5 ma-1 rounded-circle d-inline-block green"
            ></div>
            <div
              v-else-if="workday.start"
              class="pa-5 ma-1 rounded-circle d-inline-block yellow"
            ></div>
            <div
              v-else
              class="pa-5 ma-1 rounded-circle d-inline-block red"
            ></div>
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>
<script>
import store from "../../store/index";
import monthPicker from "./monthPicker.vue";
import moment from "moment";
import filtrField from "./filtrField.vue";
import weekPicker from "./weekPicker.vue";

export default {
  components: {
    monthPicker,
    filtrField,
    weekPicker,
  },
  computed: {
    users() {
      return store.getters.getUsers;
    },
    permissions() {
      return store.getters.getUserPermissions;
    },
  },
  methods: {
    getUsers() {
      console.log("fasfafa;;m");
      store.dispatch("getUsersByDatesName", this);
    },
  },
  created() {
    store.commit(
      "setUsersStart",
      moment().subtract(7, "days").format("YYYY-MM-DD")
    );
    store.commit("setUsersStop", moment().format("YYYY-MM-DD"));
    store.commit("setUsersName", "");
    this.getUsers();
  },
};
</script>
