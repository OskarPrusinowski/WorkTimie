<template>
  <v-col cols="12" sm="6" md="3">
    <v-text-field
      label="Nazwa użytkownika"
      outlined
      v-model="name"
      @input="changed(name)"
    ></v-text-field>
  </v-col>
</template>
<script>
import store from "../../store/index";
export default {
  data() {
    return {
      name: store.getters.getApplicationsUserName,
    };
  },
  methods: {
    changed(name) {
      if (name.length > 3) {
        store.commit("setApplicationsUserName", name);
      } else if (name.length <= 3) {
        store.commit("setApplicationsUserName", "");
      }
      this.$emit("changedName");
    },
  },
  created() {},
};
</script>