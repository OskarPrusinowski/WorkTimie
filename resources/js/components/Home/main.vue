<template>
  <div v-if="permissions.workdaysShow">
    <div>
      <div>
        <strong>Harmonogram na czas: </strong>
        {{ moment(today).format("YYYY-MM-DD") }}
      </div>
      <div class="pa-3">
        <div style="float: right">
          <another-users :userId="user.id" />
        </div>
        <v-btn v-if="!workday.start" @click="startWork()"> Zacznij pracę</v-btn>

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
                    moment(worktime, "H:mm:ss").diff(
                      moment(breaktime, "H:mm:ss").add(
                        workday.breaktime,
                        "minutes"
                      )
                    )
                  )
                  .format("H:mm:ss")
              }}
            </div>
            <div class="additionalHour">
              <div v-if="workday.additional_hours > 0">
                <strong> Musisz wypracować dodatkowo: </strong>
                {{ Math.floor(workday.additional_hours / 60) }}
                <strong> godzin</strong>
                <span v-if="workday.additional_hours % 60">
                  {{ workday.additional_hours % 60 }}
                  <strong> minut</strong></span
                >
              </div>
              <div v-else-if="workday.additional_hours < 0">
                <strong> Masz do odebrania: </strong
                >{{ -workday.additional_hours }}
                <strong> minut</strong>
              </div>
            </div>
            <div v-if="workday.overtime > 0" class="overtimes">
              <div>
                <strong>Zatwierdzone nadgodziny: </strong>
                {{ workday.overtime / 60 }}
              </div>
            </div>
            <div style="display: inline-block" class="addApplication ma-3">
              <create-application :userId="user.id" :moment="moment" />
            </div>
            <div></div>
            <div
              style="display: inline-block"
              class="addAdditionalHourApplication ma-3"
            >
              <create-additional-hour-application :userId="user.id" />
            </div>
            <div class="endOfTheWork">
              <strong>Szacowany czas zakończenia pracy: </strong>
              {{
                moment(workday.start)
                  .add(group.worktime, "hours")
                  .add(workday.breaktime, "minutes")
                  .add(workday.additional_hours, "minutes")
                  .add(workday.overtime, "minutes")
                  .format("H:mm")
              }}
            </div>
          </div>
        </span>
      </div>
      <div class="pa-3" v-if="workday.start && !workday.stop">
        <div class="startStopWorkPeriod ma-3">
          <v-btn @click="startPeriod(workday, 0)">
            <span v-if="isBreak" @click="resetBreaktime()"> Zrób przerwę </span>
            <span v-else>Koniec przerwy</span>
          </v-btn>
        </div>
        <span v-if="!isBreak && workday.work_periods.length > 0">
          Przerwa trwa:
          {{ breaktime }}
        </span>
        <div class="private ma-3">
          <v-btn v-if="isBreak" @click="startPeriod(workday, 1)">
            <span @click="resetBreaktime()"> Wyjście w celach prywatnych </span>
          </v-btn>
        </div>
        <div class="workPeriods ma-3">
          <work-periods :workPeriods="workday.work_periods" />
        </div>
      </div>
      <create-additional-hour
        :show="dialog"
        :minutes="additionalTime"
        @closeDialog="closeDialog()"
      />
    </div>
  </div>
</template>

<script>
import moment from "moment";
import store from "../../store/index";
import workPeriods from "./workPeriods";
import createAdditionalHour from "./createAdditionalHour";
import createApplication from "./createApplication";
import createAdditionalHourApplication from "./createAdditionalHourApplication.vue";
import anotherUsers from "./anotherUsers";

export default {
  components: {
    workPeriods: workPeriods,
    createAdditionalHour: createAdditionalHour,
    createApplication: createApplication,
    createAdditionalHourApplication: createAdditionalHourApplication,
    anotherUsers: anotherUsers,
  },
  data() {
    return {
      today: new Date(Date.now()),
      moment: moment,
      breaktime: 0,
      worktime: 0,
      dialog: false,
      additionalTime: 0,
    };
  },
  computed: {
    workday() {
      return store.getters.getWorkday;
    },
    isBreak() {
      return Boolean(this.workday.work_periods.length % 2 == 1);
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
      for (var i = 0; i < additionalHours.length; i++) {
        minutes += additionalHours[i].minutes;
      }
      return minutes;
    },
    user() {
      return store.getters.getActualUser;
    },
    overtimes() {
      return store.getters.getOvertimes;
    },
    overtimesMinutes() {
      var minutes = 0;
      var overtimes = this.overtimes;
      for (var i = 0; i < overtimes.length; i++) {
        minutes += overtimes[i].minutes;
      }
      return minutes;
    },
  },
  methods: {
    closeDialog() {
      this.dialog = false;
      this.getActualWorkday();
    },
    async startWork() {
      store.commit("setWorkday", {});
      store.commit("setWorkdayUserId", this.user.id);
      store.commit("setWorkdayDefaultWorktime", this.group.worktime);
      store.dispatch("startWorkday", this);
      await this.getActualWorkday();
      this.startPeriod(this.workday, 0);
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
    async startPeriod(workday, isPrivate) {
      const workPeriods = workday.work_periods;
      const workdayId = workday.id;
      const l = workPeriods.length;
      if (l != 0) {
        this.stopPeriod(workPeriods[l - 1]);
      }

      store.commit("setWorkPeriodWorkdayId", workdayId);
      store.commit("setWorkPeriodIsPrivate", isPrivate);
      if (l % 2 == 0) {
        store.commit("setWorkPeriodType", "Work");
      } else {
        store.commit("setWorkPeriodType", "Break");
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
            ) +
            parseInt(
              moment.utc(moment().diff(moment(workPeriod.start))).format("HH")
            ) *
              60
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
          .format("H:mm:ss");
      }
    },
    resetWorktime() {
      this.worktime = moment
        .utc(moment().diff(moment(this.workday.start)))
        .format("H:mm:ss");
    },
    resetTime() {
      this.resetWorktime();
      this.resetBreaktime();
    },
    async getAdditionalHours() {
      await store.dispatch("getAdditionalHoursByUser", this);
    },
    async getOvertimes() {
      await store.dispatch("getOvertimesToday", this);
    },
    createAdditionalHour() {
      var worktime = moment.utc(moment().diff(moment(this.workday.start)));
      this.additionalTime =
        this.group.worktime * 60 -
        worktime.hour() * 60 +
        worktime.minute() +
        this.additionalMinutes;
      if (this.additionalTime > 20) {
        this.dialog = true;
        store.commit("setAdditionalHour", {});
        store.commit(
          "setAdditionalHourUserId",
          store.getters.getActualUserGroupId
        );
        store.commit("setAdditionalHourMinutes", this.additionalTime);
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
    store.commit("setAdditionalHourUserId", this.user.id);
    store.commit("setOvertimesUserId", this.user.id);
    await this.getGroup();
    await this.getActualWorkday();
    await this.getAdditionalHours();
    await this.getOvertimes();
    this.resetTime();
  },
  mounted: function () {
    this.$nextTick(function () {
      window.setInterval(() => {
        this.resetTime();
      }, 1000);
    });
  },
};
</script>
