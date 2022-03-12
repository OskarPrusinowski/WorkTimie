<template>
  <div>
    <div>
      <strong>Harmonogram na czas: </strong>
      {{ moment(today).format("MMMM Do YYYY") }}
    </div>
    <v-card>
      <div class="pa-3">
        <v-btn v-if="!workday.start" @click="startWork()">
          Rozpocznij pracę</v-btn
        >
        <v-btn v-else :disabled="workday.stop" @click="stopWork()">
          Zakończ pracę</v-btn
        >
      </div>
      <v-divider></v-divider>
      <div class="pa-3" v-if="workday.start && !workday.stop">
        <v-btn @click="makeBreak(workday.id)">Zrób przerwę</v-btn>
      </div>
    </v-card>
    {{ workday }}
  </div>
</template>

<script>
import moment from "moment";
import store from "../../store/index";
export default {
  data() {
    return {
      today: new Date(Date.now()),
      moment: moment,
    };
  },
  computed: {
    workday() {
      return store.getters.getWorkday;
    },
  },
  methods: {
    startWork() {
      store.commit("setWorkday", {});
      store.commit("setWorkdayUserId", store.getters.getActualUserId);
      store.dispatch("startWorkday", this);
      this.getActualWorkday();
    },
    stopWork() {
      store.dispatch("stopWorkday", this);
      this.getActualWorkday();
    },
    getActualWorkday() {
      store.dispatch("getActualWorkday", this);
    },
    makeBreak(workdayId) {
      console.log("break xdddddd");
    },
  },
  async created() {
    await store.dispatch("getActualUser", this);
    store.commit("setWorkdayUserId", store.getters.getActualUserId);
    this.getActualWorkday();
  },
};
</script>
