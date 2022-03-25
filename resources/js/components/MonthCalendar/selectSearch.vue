<template>
  <v-col cols="12" sm="6" md="4">
    <v-autocomplete
      v-model="userId"
      :items="users"
      :item-text="getUserText"
      item-value="id"
      label="Pracownik"
      @change="changedUserId(userId)"
    >
    </v-autocomplete>
  </v-col>
</template>
<script>
import store from "../../store/index";
export default {
  data() {
    return {
      userId: 0,
    };
  },
  computed: {
    users() {
      return store.getters.getUsers;
    },
  },
  methods: {
    getUsers() {
      store.dispatch("getUsers", this);
    },
    getUserText(user) {
      return `${user.name} ${user.surname}`;
    },
    changedUserId(userId) {
      store.commit("setWorkdaysUserId", userId);
      this.$emit("changedUserId");
    },
    text: (item) => item.name + " — " + item.surname,
  },
  created() {
    this.userId = store.getters.getWorkdaysUserId;
    this.getUsers();
  },
};
</script>
