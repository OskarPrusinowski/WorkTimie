<template>
  <div>
    <v-spacer></v-spacer>
    <div>
      <filtr-field @changedName="getLeaves()" />
    </div>
    <v-simple-table>
      <thead>
        <tr>
          <th>Lp</th>
          <th>Użytkownik</th>
          <th>Start</th>
          <th>Koniec</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(leave, index) in leaves" :key="leave.id">
          <td>{{ index + 1 }}</td>
          <td>{{ leave.user.name }} {{ leave.user.surname }}</td>
          <td>{{ leave.start }}</td>
          <td>{{ leave.end }}</td>
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
export default {
  components: {
    yearPicker,
    filtrField,
  },
  computed: {
    leaves() {
      return store.getters.getLeaves;
    },
  },
  methods: {
    getLeaves() {
      store.dispatch("getLeaves", this);
    },
  },
  created() {
    store.commit("setLeavesDate", moment().format("YYYY-MM"));
    store.commit("setLeavesUserName", "");
    this.getLeaves();
  },
};
</script>