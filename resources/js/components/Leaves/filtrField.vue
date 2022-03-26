<template>
  <v-col cols="12" sm="6" md="3" style="display: inline-block">
    <v-text-field
      label="Pracownik"
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
      name: store.getters.getLeavesUserName,
    };
  },
  methods: {
    changed(name) {
      if (name.length > 3) {
        store.commit("setLeavesUserName", name);
      } else if (name.length < 3) {
        store.commit("setLeavesUserName", "");
      }
      this.$emit("changedName");
    },
  },
  created() {},
};
</script>
