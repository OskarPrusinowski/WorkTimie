<template>
  <v-app>
    <v-card class="pa-8">
      <div class="home" style="display: inline-block">
        <router-link to="/">
          <v-btn icon> <v-icon>home</v-icon></v-btn>
        </router-link>
        <div class="calendar" style="display: inline-block">
          <router-link to="/monthCalendar">
            <v-btn depressed color="primary"> Kalendarz miesięczny </v-btn>
          </router-link>
        </div>
      </div>
      <div style="float: right; display: inline-block">
        <div class="users" style="display: inline-block">
          <router-link to="/users/list">
            <v-btn depressed color="primary"> Użytkownicy </v-btn>
          </router-link>
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
  computed: {},
  data() {
    return {
      message: "Hello World",
    };
  },
  created() {
    store.dispatch("getActualUser", this);
  },
};
</script>
<style scoped>
li a {
  text-decoration: none;
}
</style>
