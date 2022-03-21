<template>
  <div>
    <v-btn @click="prev()"> <v-icon>mdi-chevron-left</v-icon></v-btn>
    {{ year }}
    <v-btn @click="next()"> <v-icon>mdi-chevron-right</v-icon></v-btn>
  </div>
</template>

<script>
import store from "../../store/index";
import moment from "moment";
export default {
  computed: {
    year() {
      return store.getters.getHolidaysDate;
    },
  },
  methods: {
    setActualYear() {
      store.commit("setHolidaysDate", moment().format("yyyy"));
    },
    prev() {
      this.changeYear(-1);
    },
    next() {
      this.changeYear(1);
    },
    changeYear(n) {
      store.commit("setHolidaysDate", parseInt(this.year) + n);
      this.getHolidays();
    },
    getHolidays() {
      store.dispatch("getHolidays", this);
    },
  },
  created() {
    this.setActualYear();
    this.getHolidays();
  },
};
</script>