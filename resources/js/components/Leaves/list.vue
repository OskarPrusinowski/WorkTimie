<template>
  <div v-if="permissions.leavesManage">
    <department-filtr @changedDepartment="getLeaves()" />
    <filtr-field @changedName="getLeaves()" />
    <div></div>
    <v-simple-table v-if="users">
      <thead>
        <tr>
          <th>Użytkownik</th>
          <th>Dział</th>
          <th v-for="date in leaves[0]" :key="date">
            {{ moment(date).format("MM-DD") }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(leave, index) in leaves" :key="leave" v-if="index">
          <td v-for="date in leave" :key="date">
            <div
              v-if="date == 1"
              class="pa-4 ma-1 rounded-circle d-inline-block grey"
            ></div>
            <div
              v-else-if="date == 0"
              class="pa-4 ma-1 rounded-circle d-inline-block green"
            ></div>
            <span v-else>
              {{ date }}
            </span>
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
import store from "../../store/index";
import moment from "moment";
import yearPicker from "./yearPicker.vue";
import filtrField from "./filtrField.vue";
import departmentFiltr from "./departmentFiltr";

export default {
  data() {
    return {
      moment: moment,
    };
  },
  components: {
    yearPicker,
    filtrField,
    departmentFiltr,
  },
  computed: {
    leaves() {
      return store.getters.getLeaves;
    },
    users() {
      return store.getters.getUsers;
    },
    permissions() {
      return store.getters.getUserPermissions;
    },
  },
  methods: {
    getLeaves() {
      store.dispatch("getLeaves", this);
    },
  },
  created() {
    store.commit("setLeavesDate", moment().format("YYYY-MM"));
    store.commit("setLeavesDate", moment().format("YYYY-MM"));
    store.commit("setLeavesUserName", "");
    this.getLeaves();
  },
};
</script>
