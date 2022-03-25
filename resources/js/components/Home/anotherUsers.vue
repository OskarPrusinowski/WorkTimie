<template>
  <v-card>
    <v-layout column
      ><v-flex>
        <v-simple-table>
          <thead>
            <tr>
              <th>Status</th>
              <th>Użytkownicy</th>
              <th>Przewdiywana godzina zakończenia</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="workday in workdays.filter(
                (workday) => !workday.user.date_stop_employment
              )"
              :key="workday.id"
            >
              <td v-if="workday.holiday">
                <div class="pa-4 ma-1 rounded-circle d-inline-block grey"></div>
              </td>
              <td v-else-if="workday.stop">
                <div
                  class="pa-4 ma-1 rounded-circle d-inline-block yellow"
                ></div>
              </td>
              <td v-else-if="workday.start">
                <div
                  class="pa-4 ma-1 rounded-circle d-inline-block green"
                ></div>
              </td>
              <td v-else>
                <div class="pa-4 ma-1 rounded-circle d-inline-block red"></div>
              </td>
              <td>{{ workday.user.name }} {{ workday.user.surname }}</td>
              <td v-if="workday.stop">
                {{ moment(workday.stop).format("H:mm") }}
              </td>
              <td v-else-if="workday.start">
                {{
                  moment(workday.start)
                    .add(workday.default_worktime, "hours")
                    .add(workday.additional_hours, "minutes")
                    .add(workday.breaktime, "minutes")
                    .add(workday.overtime, "minutes")
                    .format("H:mm")
                }}
              </td>
              <td v-else-if="workday.holiday">
                {{ workday.holiday }}
              </td>
              <td v-else>-----</td>
            </tr>
          </tbody>
        </v-simple-table></v-flex
      >
    </v-layout>
  </v-card>
</template>

<script>
import store from "../../store/index";
import moment from "moment";
export default {
  props: ["userId"],
  data() {
    return {
      moment: moment,
    };
  },
  computed: {
    workdays() {
      return store.getters.getWorkdays;
    },
  },
  methods: {
    getAnotherWorkdays() {
      store.commit("setWorkdaysUserId", this.userId);
      store.dispatch("getAnotherWorkdays", this);
    },
  },
  created() {
    this.getAnotherWorkdays();
  },
};
</script>
<style scoped>
.green {
  background-color: green;
}
.grey {
  background-color: grey;
}
.red {
  background-color: red;
}
.yellow {
  background-color: yellow;
}
</style>
