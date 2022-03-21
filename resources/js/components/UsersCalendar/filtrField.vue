<template>
  <div>
    <v-col cols="12" sm="6" md="3" style="flex-wrap: nowrap; overflow-x: auto">
      <v-text-field
        label="Nazwa użytkownika"
        outlined
        v-model="name"
        @input="changed(name)"
      ></v-text-field>
    </v-col>
  </div>
</template>
<script>
import store from "../../store/index";
export default {
  data() {
    return {
      name: store.getters.setUsersName,
    };
  },
  methods: {
    changed(name) {
      if (name.length > 3) {
        store.commit("setUsersName", name);
      } else if (name.length <= 3) {
        store.commit("setUsersName", "");
      }
      this.$emit("changedName");
    },
  },
  created() {},
};
</script>