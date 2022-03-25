<template>
  <div v-if="permissions.leavesShow">
    <span>
      Ilość wolnych dni dostępnych {{ user.current_counter_holidays }}</span
    >
    <create :userId="user.id" v-if="permissions.applicationsManage" />
    <v-simple-table>
      <thead>
        <tr>
          <th>Lp</th>
          <th>Start</th>
          <th>Koniec</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(leave, index) in leaves" :key="leave.id">
          <td>{{ index + 1 }}</td>
          <td>{{ leave.start }}</td>
          <td>{{ leave.end }}</td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>
<script>
import store from "../../store/index";
import create from "./create";
export default {
  components: {
    create,
  },
  computed: {
    leaves() {
      return store.getters.getLeaves;
    },
    user() {
      return store.getters.getActualUser;
    },
    permissions() {
      return store.getters.getUserPermissions;
    },
  },
  methods: {
    getLeaves() {
      store.dispatch("getLeavesByUser", this);
    },
  },
  async created() {
    await store.dispatch("getActualUser", this);
    store.commit("setLeavesUserId", this.user.id);
    this.getLeaves();
  },
};
</script>