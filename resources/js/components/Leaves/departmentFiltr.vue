<template>
  <v-col cols="12" sm="6" md="3" style="display: inline-block">
    <v-select
      @change="changedDepartment(departmentId)"
      :items="departments"
      item-text="name"
      item-value="id"
      label="Dział"
      v-model="departmentId"
    ></v-select>
  </v-col>
</template>
<script>
import store from "../../store/index";
export default {
  computed: {
    departments() {
      return store.getters.getDepartments;
    },
  },
  data() {
    return {
      departmentId: 0,
    };
  },
  methods: {
    changedDepartment(departmentId) {
      store.commit("setLeavesDepartmentId", departmentId);
      this.$emit("changedDepartment");
    },
    async getDepartments() {
      await store.dispatch("getDepartments", this);
    },
  },
  async created() {
    this.departmentId = store.getters.getLeavesDepartmentId;
    await this.getDepartments();
    this.departments.push({ id: 0, name: "Wszystko" });
  },
};
</script>
