<template>
  <v-col style="display: inline-block" cols="12" sm="6" md="3">
    <v-select
      @change="changedStatus(status)"
      :items="statuses"
      item-text="name"
      item-value="val"
      label="Status"
      v-model="status"
    ></v-select>
  </v-col>
</template>
<script>
import store from "../../store/index";
export default {
  data() {
    return {
      statuses: [
        { name: "Wszystkie", val: "" },
        { name: "Zaakceptowany", val: "Zaakceptowany" },
        { name: "Odrzucony", val: "Odrzucony" },
        { name: "Oczekiwany", val: "Oczekiwany" },
      ],
      status: "",
    };
  },
  methods: {
    changedStatus(status) {
      store.commit("setApplicationsStatus", status);
      this.$emit("changedStatus");
    },
  },
  created() {
    this.status = store.getters.getApplicationsStatus;
  },
};
</script>