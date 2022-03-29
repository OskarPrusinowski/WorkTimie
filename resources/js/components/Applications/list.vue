<template>
  <div v-if="permissions.applicationsShow">
    <create-comment :dialog="dialog" @closed="update()" />
    <div>
      <status-filtr
        v-if="permissions.applicationsAdminManage"
        @changedStatus="getApplications()"
      />
      <filtr-field
        v-if="permissions.applicationsAdminManage"
        @changedName="getApplications()"
      ></filtr-field>
      <div></div>
    </div>
    <v-simple-table>
      <thead>
        <tr>
          <th class="text-left">Lp</th>
          <th class="text-left">Numer wniosku</th>
          <th class="text-left" v-if="permissions.applicationsAdminManage">
            Pracownik
          </th>
          <th class="text-left">Typ</th>
          <th class="text-left">Data wysłania</th>
          <th class="text-left">Termin</th>
          <th class="text-left">Data akceptacji</th>
          <th class="text-left">Ilość godzin</th>
          <th class="text-left">Komentarz</th>
          <th class="text-left">Status</th>
          <th class="text-left">Komentarz akceptującego</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(application, index) in applications" :key="application.id">
          <td class="text-left">{{ index + 1 }}</td>
          <td class="text-left">{{ application.number }}</td>
          <td class="text-left" v-if="permissions.applicationsAdminManage">
            {{ application.user.name }} {{ application.user.surname }}
          </td>
          <td class="text-left">{{ application.type }}</td>
          <td class="text-left">{{ application.date }}</td>
          <td
            class="text-left"
            v-if="
              application.first_date &&
              application.first_date != application.second_date
            "
          >
            {{ application.first_date }} - {{ application.second_date }}
          </td>
          <td class="text-left" v-else>{{ application.second_date }}</td>
          <td class="text-left" v-if="application.acceptation_date">
            {{ application.acceptation_date }}
          </td>
          <td class="text-left" v-else>----------</td>
          <td class="text-left" v-if="application.minutes">
            {{ application.minutes / 60 }}
          </td>
          <td class="text-left" v-else>----------</td>
          <td class="text-left">{{ application.comment }}</td>

          <td class="text-left" v-if="application.acceptation_date">
            <div
              v-if="application.status == 'Zaakceptowany'"
              class="pa-4 ma-1 rounded-circle d-inline-block green"
            ></div>
            <div
              v-else
              class="pa-4 ma-1 rounded-circle d-inline-block red"
            ></div>
          </td>
          <td class="text-left" v-else-if="permissions.applicationsAdminManage">
            <v-btn
              @click="accept(application)"
              :disabled="application.acceptation_date"
            >
              <v-icon>mdi-check-bold </v-icon>
            </v-btn>

            <v-btn
              @click="reject(application.id)"
              :disabled="application.acceptation_date"
            >
              <v-icon> mdi-close-thick </v-icon>
            </v-btn>
          </td>
          <td class="text-left" v-else>
            <div class="pa-4 ma-1 rounded-circle d-inline-block yellow"></div>
          </td>
          <td class="text-left">
            {{ application.acceptation_comment }}
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
import store from "../../store/index";
import monthPicker from "./monthPicker.vue";
import moment from "moment";
import statusFiltr from "./statusFiltr.vue";
import filtrField from "./filtrField.vue";
import createComment from "./createComment";
export default {
  data() {
    return {
      moment: moment,
      dialog: false,
    };
  },
  components: {
    monthPicker,
    statusFiltr,
    filtrField,
    createComment,
  },
  computed: {
    applications() {
      return store.getters.getApplications;
    },
    user() {
      return store.getters.getActualUser;
    },
    permissions() {
      return store.getters.getUserPermissions;
    },
  },
  methods: {
    async createTwoAdditionalHours(application) {
      store.commit("setAdditionalHour", {});
      store.commit("setAdditionalHourMinutes", application.minutes);
      store.commit("setAdditionalHourDate", application.second_date);
      store.commit("setAdditionalHourUserId", application.user_id);
      await store.dispatch("createAdditionalHour", this);
      store.commit("setAdditionalHourMinutes", -application.minutes);
      store.commit("setAdditionalHourDate", application.first_date);
      await store.dispatch("createAdditionalHour", this);
    },
    update() {},
    accept(application) {
      store.commit("setApplicationAccepted", 1);
      this.considerApplication(application.id);
      switch (application.type) {
        case "Nadgodziny":
          this.createOvertime(application);
          this.addTimeWorkday(application);
          break;
        case "Wcześniejsze zakończenie pracy":
          this.createTwoAdditionalHours(application);
          this.addTimeWorkday(application);
          break;
        case "Urlop":
          this.createLeave(application);
          break;
      }
    },
    addTimeWorkday(application) {
      if (moment().format("yyyy-MM-DD") == application.second_date) {
        store.commit("setWorkdaysUserId", this.user.id);
        store.commit("setWorkdaysDate", application.second_date);
        if (application.type == "Nadgodziny") {
          store.commit("setWorkdaysMinutes", application.minutes);
        } else {
          store.commit("setWorkdaysMinutes", -application.minutes);
        }
        store.commit("setWorkdaysType", application.type);

        store.dispatch("addTimeWorkday", this);
      }
    },
    reject(id) {
      store.commit("setApplicationAccepted", 0);
      this.considerApplication(id);
    },
    considerApplication(id) {
      store.commit("setApplicationId", id);
      store.commit("setAcceptationId", this.user.id);
      this.dialog = true;
    },
    update() {
      store.dispatch("considerApplcation", this);
      this.getApplications();
      store.dispatch("getWaitingApplicationsCounter", this);
      this.dialog = false;
    },
    async createLeave(application) {
      store.commit("setLeave", {});
      store.commit("setLeaveStart", application.first_date);
      store.commit("setLeaveEnd", application.second_date);
      store.commit("setLeaveUserId", application.user_id);
      await store.dispatch("createLeave", this);
      store.commit("setUser", {});
      store.commit("setUserId", application.user_id);
      store.dispatch("updateHolidaysCounter", this);
    },
    createOvertime(application) {
      store.commit("setOvertime", {});
      store.commit("setOvertimeMinutes", application.minutes);
      store.commit("setOvertimeDate", application.second_date);
      store.commit("setOvertimeUserId", application.user_id);
      store.dispatch("createOvertime", this);
    },
    getApplications() {
      store.dispatch("getApplications", this);
    },
  },
  created() {
    store.commit("setApplicationsMonth", this.moment().format("YYYY-MM"));
    store.commit("setApplicationsUserName", "");
    this.getApplications();
  },
};
</script>
