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
        class="calendar"
        style="display: inline-block"
        v-if="permissions.workdaysShow"
      >
        <router-link to="/monthCalendar">
          <v-btn depressed color="primary"> Kalendarz miesięczny </v-btn>
        </router-link>
      </div>
      <div style="float: right; display: inline-block">
        <div
          class="users"
          style="display: inline-block"
          v-if="permissions.usersShow"
        >
          <router-link to="/users/list">
            <v-btn depressed color="primary"> Użytkownicy </v-btn>
          </router-link>
        </div>
        <div
          class="applications"
          style="display: inline-block"
          v-if="permissions.holidaysShow"
        >
          <router-link to="/applications/list">
            <v-btn depressed color="primary"> Akceptacja </v-btn>
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
export default {
  computed: {
    permissions() {
      return store.getters.getUserPermissions;
    },
    actualUser() {
      return store.getters.getActualUser;
    },
  },
  data() {
    return {};
  },
  methods: {
    logout() {
      this.$http.post("http://127.0.0.1:8000/logout").then((response) => {
        console.log(response);
      });
      store.dispatch("getActualUser", this);
      window.location.reload();
    },
  },
  async beforeCreate() {
    await store.dispatch("getActualUser", this);
    store.commit("setPermissionsUserId", store.getters.getActualUserId);
    store.dispatch("getUserPermissions", this);
  },
};
</script>
<style scoped>
li a {
  text-decoration: none;
}
</style>
