<template>
  <div v-if="permissions.holidaysShow">
    <v-divider></v-divider>
    <create v-if="permissions.holidaysManage" @added="addedHoliday" />
    <v-simple-table>
      <thead>
        <tr>
          <th class="text-left">Lp</th>
          <th class="text-left">Nazwa</th>
          <th class="text-left">Dzień tygodnia</th>
          <th class="text-left">Data</th>
          <th class="text-left">Usuń</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(holiday, index) in holidays" :key="holiday.id">
          <td class="text-left">{{ index + 1 }}</td>
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
import yearPicker from "./yearPicker";

export default {
  data() {
    return {};
  },
  components: {
    create,
    yearPicker,
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
  },
};
</script>
