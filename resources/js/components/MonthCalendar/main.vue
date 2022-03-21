<template>
  <div v-if="permissions.workdaysShow">
    <v-divider></v-divider>
    <v-simple-table id="table">
      <thead>
        <tr>
          <th class="text-left">Lp</th>
          <th class="text-left">Dzien tygodnia</th>
          <th class="text-left">Rozpoczecie pracy</th>
          <th class="text-left">Czas pracy</th>
          <th class="text-left">Zakonczenie pracy</th>
          <th class="text-left">Przerwy</th>
          <th class="text-left">Nadgodziny</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(workday, index) in workdays" :key="workday.id">
          <td class="text-left">{{ index + 1 }}</td>
          <td class="text-left">{{ workday.day }}</td>
          <td class="text-left">
            {{ moment(workday.start).format("h:mm") }}
          </td>
          <td class="text-left" v-if="workday.worktime">
            {{ workday.worktime }} (minut)
          </td>
          <td class="text-left" v-else>
            {{
              moment
                .utc(
                  moment().diff(
                    moment(workday.start).add(workday.breaktime, "minutes")
                  )
                )
                .format("HH:mm:ss")
            }}
          </td>
          <td class="text-left" v-if="workday.stop">
            {{ moment(workday.stop).format("h:mm") }}
          </td>
          <td class="text-left" v-else></td>
          <td class="text-left">{{ workday.breaktime }}</td>
          <td class="text-left">{{ workday.overtime }}</td>
        </tr>
      </tbody>
    </v-simple-table>
    <v-divider></v-divider>
    <div style="text-align: center">
      <v-btn depressed color="blue lighten-2" dark @click="downloadPDF()"
        >Pobierz tabelkę</v-btn
      >
    </div>
  </div>
</template>
<script>
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import store from "../../store/index";
import moment from "moment";
import monthPicker from "./monthPicker.vue";

export default {
  components: {
    monthPicker,
  },
  data() {
    return {
      moment: moment,
      picker: moment().format("YYYY-MM"),
    };
  },
  computed: {
    workdays() {
      return store.getters.getWorkdays;
    },
    actualUser() {
      return store.getters.getActualUser;
    },
    maxMonth() {
      if (this.actualUser.date_stop_employment) {
        return this.actualUser.date_stop_employment;
      }
      return moment().format("YYYY-MM-DD");
    },
    permissions() {
      return store.getters.getUserPermissions;
    },
  },
  methods: {
    async getWorkDays() {
      await store.dispatch("getWorkdays", this);
    },
    changeMonth(id) {
      this.getWorkDays;
    },
    async downloadPDF() {
      window.html2canvas = html2canvas;
      var doc = new jsPDF("p", "pt", "a1");
      var tab = document.getElementById("table");
      tab.classList.add("spacing");
      await doc.html(document.querySelector("#table"), {
        callback: function (pdf) {
          pdf.save("mypdf.pdf");
        },
      });
      tab.classList.remove("spacing");
    },
  },
  async created() {
    await store.dispatch("getActualUser", this);
    store.commit("setWorkdaysUserId", store.getters.getActualUserId);
    this.getWorkDays();
  },
};
</script>

<style scoped>
.spacing {
  letter-spacing: 1px;
}
</style>
