<template>
  <div v-if="permissions.workdaysShow">
    <div>
      <strong>Harmonogram na czas: </strong>
      {{ moment(today).format("YYYY-mm-DD") }}
    </div>
    <v-card>
      <div class="pa-3">
        <v-btn v-if="!workday.start" @click="startWork()">
          Rozpocznij pracę</v-btn
        >
        <span v-else>
          <div class="pb-4">
            <strong>Rozpoczęcie pracy: </strong
            >{{ moment(workday.start).format("H:mm") }}
          </div>
          <v-btn
            :disabled="workday.stop"
            @click="stopWork(workday.work_periods)"
          >
            Zakończ pracę</v-btn
          >
          <div class="pt-4 pb-3" v-if="workday.stop">
            <strong>Zakończenie pracy: </strong>
            {{ moment(workday.stop).format("H:mm") }}
          </div>
          <div v-else-if="workday.start">
            <div class="mt-3 workTime">
              <strong>Czas pracy: </strong>
              {{
                moment
                  .utc(
                    moment(worktime, "HH:mm:ss").diff(
                      moment(breaktime, "HH:mm:ss").add(
                        workday.breaktime,
                        "minutes"
                      )
                    )
                  )
                  .format("HH:mm:ss")
              }}
            </div>
            <div class="additionalHour">
              <div v-if="additionalMinutes > 0">
                <strong> Musisz wypracować dodatkowo: </strong>
                {{ additionalMinutes }} <strong> minut</strong>
              </div>
              <div v-else-if="additionalMinutes < 0">
                <strong> Masz do odebrania: </strong> {{ additionalMinutes }}
                <strong> minut</strong>
              </div>
            </div>
            <div class="addApplication">
              <create-application :userId="user.id" />
            </div>
            <div class="endOfTheWork">
              <strong>Szacowany czas zakończenia pracy: </strong>
              {{
                moment(workday.start)
                  .add(group.worktime, "hours")
                  .add(workday.breaktime, "minutes")
                  .add(additionalMinutes, "minutes")
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
    <create-additional-hour :show="dialog" />
  </div>
</template>

<script>
import moment from "moment";
import store from "../../store/index";
import workPeriods from "./workPeriods";
import createAdditionalHour from "./createAdditionalHour";
import createApplication from "./createApplication";

export default {
  components: {
    workPeriods: workPeriods,
    createAdditionalHour: createAdditionalHour,
    createApplication: createApplication,
  },
  data() {
    return {
      today: new Date(Date.now()),
      moment: moment,
      breaktime: 0,
      worktime: 0,
      dialog: false,
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
    additionalhours() {
      return store.getters.getAdditionalHours;
    },
    additionalMinutes() {
      var minutes = 0;
      var additionalHours = this.additionalhours;
      for (var i = 0; i < this.additionalhours.length; i++) {
        minutes += additionalHours[i].minutes;
      }
      return minutes;
    },
    user() {
      return store.getters.getActualUser;
    },
  },
  methods: {
    startWork() {
      store.commit("setWorkday", {});
      store.commit("setWorkdayUserId", this.user.id);
      store.dispatch("startWorkday", this);
      this.getActualWorkday();
    },
    async stopWork(workPeriods) {
      store.dispatch("stopWorkday", this);
      if (workPeriods.length > 0) {
        this.stopPeriod(workPeriods[workPeriods.length - 1]);
      } else {
        await this.getActualWorkday();
      }
      this.createAdditionalHour();
    },
    async getActualWorkday() {
      await store.dispatch("getWorkday", this);
    },
    async startPeriod(workday) {
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
      await this.getActualWorkday();
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
      if (
        this.workday.work_periods[this.workday.work_periods.length - 1].type ==
        "Work"
      ) {
        this.breaktime = 0;
      } else {
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
      }
    },
    resetWorktime() {
      this.worktime = moment
        .utc(moment().diff(moment(this.workday.start)))
        .format("HH:mm:ss");
    },
    resetTime() {
      this.resetWorktime();
      this.resetBreaktime();
    },
    async getAdditionalHours() {
      await store.dispatch("getAdditionalHoursByUser", this);
    },
    createAdditionalHour() {
      var additionalTime =
        this.group.worktime * 60 -
        this.workday.worktime +
        this.additionalMinutes;
      if (additionalTime > 20) {
        this.dialog = true;
        store.commit("setAdditionalHour", {});
        store.commit(
          "setAdditionalHourUserId",
          store.getters.getActualUserGroupId
        );
        store.commit("setAdditionalHourMinutes", additionalTime);
      }
    },
  },
  async created() {
    await store.dispatch("getActualUser", this);
    store.commit("setWorkday", {});
    store.commit("setWorkdayUserId", this.user.id);
    store.commit("setGroup", {});
    store.commit("setGroupId", store.getters.getActualUserGroupId);
    store.commit("setAdditionalHour", {});
    store.commit("setAdditionalHourUserId", store.getters.getActualUserGroupId);
    await this.getGroup();
    await this.getActualWorkday();
    await this.getAdditionalHours();
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
