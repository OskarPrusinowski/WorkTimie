<template>
  <div v-if="permissions.usersShow">
    <filtr-field @changedName="getUsers()" />
    <department-filtr @changedDepartment="getUsers()" />
    <create @added="addedUser" v-if="permissions.usersManage" />
    <v-simple-table v-if="permissions.usersShow">
      <thead>
        <tr>
          <th class="text-left">Id</th>
          <th class="text-left">Imię</th>
          <th class="text-left">Nazwisko</th>
          <th class="text-left">Email</th>
          <th class="text-left">Data zatrudnienia</th>
          <th class="text-left">Wolne w roku</th>
          <th class="text-left">Grupa</th>
          <th class="text-left">Dział</th>
          <th class="text-left">Zakończ współpracę</th>
          <th class="text-left">Usuń</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="text-left">{{ user.id }}</td>
          <td class="text-left">{{ user.name }}</td>
          <td class="text-left">{{ user.surname }}</td>
          <td class="text-left">{{ user.email }}</td>
          <td class="text-left">{{ user.date_start_employment }}</td>
          <td class="text-left">{{ user.current_counter_holidays }}</td>
          <td class="text-left" v-if="user.group">
            {{ user.group.name }}
          </td>
          <td class="text-left" v-else></td>
          <td class="text-left" v-if="user.department">
            {{ user.department.name }}
          </td>
          <td class="text-left" v-else></td>
          <td class="text-left">
            <v-btn
              v-if="permissions.usersManage"
              @click="fireUser(user)"
              :disabled="user.date_stop_employment"
              >Zakończ współpracę</v-btn
            >
          </td>
          <td class="text-left">
            <v-btn v-if="permissions.usersManage" @click="deleteUser(user.id)"
              ><v-icon>mdi-trash-can</v-icon></v-btn
            >
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>
<script>
import store from "../../store/index";
import create from "./create.vue";
import filtrField from "./filtrField";
import departmentFiltr from "./departmentFiltr.vue";

export default {
  components: {
    create,
    filtrField,
    departmentFiltr,
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
      store.dispatch("getUsers", this);
    },
    fireUser(user) {
      store.commit("setUser", user);
      store.commit(
        "setUserDateStopEmployment",
        new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
          .toISOString()
          .substr(0, 10)
      );
      store.dispatch("updateUser", this);
      this.getUsers();
    },
    deleteUser(id) {
      store.commit("setUserId", id);
      store.dispatch("deleteUser", this);
      this.getUsers();
    },
    addedUser() {
      this.getUsers();
    },
  },
  created() {
    console.log(this.$route.name);
    store.commit("setUsersName", "");
    this.getUsers();
  },
};
</script>
