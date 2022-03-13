<template>
  <div v-if="permissions.workdaysShow">
    <div>
      <strong>Harmonogram na czas: </strong>
      {{ moment(today).format("MMMM Do YYYY") }}
    </div>
    <v-card>
      <div class="pa-3">
        <v-btn v-if="!workday.start" @click="startWork()">
          Rozpocznij pracę</v-btn
        >
        <span v-else>
          <div class="pb-4">
            <strong>Rozpoczęcie pracy: </strong
            >{{ moment(workday.start).format("H:mm:ss") }}
          </div>
          <v-btn
            :disabled="workday.stop"
            @click="stopWork(workday.work_periods)"
          >
            Zakończ pracę</v-btn
          >
          <div class="pt-4 pb-3" v-if="workday.stop">
            <strong>Zakończenie pracy: </strong>
            {{ moment(workday.stop).format("H:mm:ss") }}
          </div>
          <div v-else-if="workday.start">
            <div class="mt-3">
              <strong>Czas pracy: </strong>
              {{ worktime }}
            </div>
            <div>
              <strong>Szacowany czas zakończenia pracy: </strong>
              {{
                moment(workday.start)
                  .add(group.worktime, "hours")
                  .add(workday.breaktime, "minutes")
                  .format("H:mm")
              }}
            </div>
          </div>
        </span>
      </div>
      <v-divider></v-divider>
      <div class="pa-3" v-if="workday.start && !workday.stop">
        <v-btn @click="startPeriod(workday)">
          <span v-if="isBreak" @click="resetBreaktime()"> Zrób przerwę </span>
          <span v-else>Koniec przerwy</span>
        </v-btn>
        <span v-if="!isBreak && workday.work_periods.length > 0">
          Przerwa trwa:
          {{ breaktime }}
        </span>
        <work-periods :workPeriods="workday.work_periods" />
      </div>
    </v-card>
  </div>
</template>

<script>
import moment from "moment";
import store from "../../store/index";
import workPeriods from "./workPeriods";

export default {
  components: {
    workPeriods: workPeriods,
  },
  data() {
    return {
      today: new Date(Date.now()),
      moment: moment,
      breaktime: 0,
      worktime: 0,
    };
  },
  computed: {
    workday() {
      return store.getters.getWorkday;
    },
    isBreak() {
      return Boolean(this.workday.work_periods.length % 2 == 0);
    },
    group() {
      return store.getters.getGroup;
    },
    permissions() {
      return store.getters.getUserPermissions;
    },
  },
  methods: {
    startWork() {
      store.commit("setWorkday", {});
      store.commit("setWorkdayUserId", store.getters.getActualUserId);
      store.dispatch("startWorkday", this);
      this.getActualWorkday();
    },
    stopWork(workPeriods) {
      store.dispatch("stopWorkday", this);
      this.stopPeriod(workPeriods[workPeriods.length - 1]);
      this.getActualWorkday();
    },
    async getActualWorkday() {
      await store.dispatch("getWorkday", this);
    },
    startPeriod(workday) {
      const workPeriods = workday.work_periods;
      const workdayId = workday.id;
      const l = workPeriods.length;
      if (l != 0) {
        this.stopPeriod(workPeriods[l - 1]);
      }
      store.commit("setWorkPeriodWorkdayId", workdayId);
      if (l % 2 == 0) {
        store.commit("setWorkPeriodType", "Break");
      } else {
        store.commit("setWorkPeriodType", "Work");
      }
      store.dispatch("startWorkPeriod", this);
      this.getActualWorkday();
    },
    stopPeriod(workPeriod) {
      if (workPeriod.type == "Break") {
        if (!store.getters.getWorkdayBreaktime) {
          store.commit("setWorkdayBreaktime", 0);
        }
        store.commit(
          "setWorkdayBreaktime",
          store.getters.getWorkdayBreaktime +
            parseInt(
              moment.utc(moment().diff(moment(workPeriod.start))).format("mm")
            )
        );
        store.dispatch("updateWorkday", this);
      }
      store.commit("setWorkPeriod", workPeriod);
      store.dispatch("stopWorkPeriod", this);
    },
    getGroup() {
      store.dispatch("getGroup", this);
    },
    resetBreaktime() {
      this.breaktime = moment
        .utc(
          moment().diff(
            moment(
              this.workday.work_periods[this.workday.work_periods.length - 1]
                .start
            )
          )
        )
        .format("HH:mm:ss");
    },
    resetWorktime() {
      this.worktime = moment
        .utc(moment().diff(moment(this.workday.start)))
        .format("HH:mm:ss");
    },
    resetTime() {
      this.resetBreaktime();
      this.resetWorktime();
    },
  },
  async created() {
    await store.dispatch("getActualUser", this);
    store.commit("setWorkday", {});
    store.commit("setWorkdayUserId", store.getters.getActualUserId);
    store.commit("setGroup", {});
    store.commit("setGroupId", store.getters.getActualUserGroupId);
    await this.getGroup();
    await this.getActualWorkday();
    this.resetTime();
  },
  mounted: function () {
    this.$nextTick(function () {
      window.setInterval(() => {
        this.resetTime();
      }, 10000);
    });
  },
};
</script>
