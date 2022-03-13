<template>
  <div v-if="permissions.workdaysShow">
    <v-col class="ma-0 pb-0 pt-2" md="3">
      <v-row justify="center">
        <v-date-picker
          v-model="picker"
          type="month"
          :min="moment(actualUser.date_start_employment).format('y-MM')"
          :max="moment(maxMonth).format('y-MM')"
          @change="getWorkDays()"
        ></v-date-picker>
      </v-row>
    </v-col>
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
            {{ moment(workday.start).format("h:mm:ss") }}
          </td>
          <td class="text-left">{{ workday.worktime }}</td>
          <td class="text-left">
            {{ moment(workday.stop).format("h:mm:ss") }}
          </td>
          <td class="text-left">{{ workday.breaktime }}</td>
          <td class="text-left">!!NADGODZINY!!</td>
        </tr>
      </tbody>
    </v-simple-table>
    {{ workdays }}
    <div>
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
export default {
  data() {
    return {
      moment: moment,
      picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 7),
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
      return new Date(Date.now());
    },
    permissions() {
      return store.getters.getUserPermissions;
    },
  },
  methods: {
    async getWorkDays() {
      store.commit("setWorkdaysDate", this.picker);
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