<template>
  <div v-if="permissions.holidaysShow">
    {{ freeSaturdays }}
    <v-col class="ma-0 pb-0 pt-2" md="3">
      <v-row justify="center">
        <v-date-picker
          v-model="picker"
          type="month"
          min="2010-01-01"
          max="2025-01-01"
          @change="changeMonth()"
        ></v-date-picker>
      </v-row>
    </v-col>
    <v-divider></v-divider>
    <v-col class="ma-0 pb-0 pt-2" md="3">
      <v-row justify="center">
        <strong> {{ picker.substr(0, 4) }} </strong>
        <v-switch
          v-model="switch1"
          :label="'Wolne w sobotę'"
          @change="changeFreeSatudays()"
        ></v-switch>
      </v-row>
    </v-col>
    <v-divider></v-divider>
    <create v-if="permissions.holidaysManage" @added="addedHoliday" />
    <v-simple-table>
      <thead>
        <tr>
          <th class="text-left">Nazwa</th>
          <th class="text-left">Dzień tygodnia</th>
          <th class="text-left">Data</th>
          <th class="text-left">Usuń</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="holiday in holidays" :key="holiday.id">
          <td class="text-left">{{ holiday.name }}</td>
          <td class="text-left">{{ holiday.day }}</td>
          <td class="text-left">{{ holiday.date }}</td>
          <td class="text-left">
            <v-btn
              v-if="permissions.holidaysManage"
              @click="deleteHoliday(holiday.id)"
              ><v-icon>mdi-trash-can</v-icon></v-btn
            >
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
import store from "../../store/index";
import create from "./create";

export default {
  data() {
    return {
      picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 7),
      switch1: false,
    };
  },
  components: {
    create,
  },
  computed: {
    permissions() {
      return store.getters.getUserPermissions;
    },
    holidays() {
      return store.getters.getHolidays;
    },
    holidaysDate() {
      return store.getters.getHolidaysDate;
    },
    freeSaturdays() {
      return store.getters.getHolidaysFreeSaturdays;
    },
  },
  methods: {
    getHolidays() {
      store.dispatch("getHolidays", this);
    },
    addedHoliday() {
      this.getHolidays();
    },
    deleteHoliday(id) {
      store.commit("setHolidayId", id);
      store.dispatch("deleteHoliday", this);
      this.getHolidays();
    },
    changeMonth() {
      store.commit("setHolidaysDate", this.picker);
      this.getHolidays();
    },
    changeFreeSatudays() {
      store.commit("setHolidaysDate", this.picker.substr(0, 4));
      store.commit("setHolidaysFreeSaturdayFree", this.switch1);
      store.dispatch("setHolidaysFreeSaturdayFree", this);
    },
    getFreeSaturdays() {
      store.dispatch("getHolidaysFreeSaturdays", this);
    },
  },
  created() {
    this.changeMonth();
    this.getFreeSaturdays();
    this.switch1 = store.getters.getHolidaysFreeSaturdays;
  },
};
</script>
