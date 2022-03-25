<template>
  <v-col cols="12" sm="6" md="4" style="display: inline-block">
    <v-dialog
      ref="dialog"
      v-model="modal"
      width="290px"
      @click:outside="close()"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-text-field
          v-model="dates"
          label="Wybierz tydzień"
          prepend-icon="mdi-calendar"
          readonly
          v-bind="attrs"
          v-on="on"
        ></v-text-field>
      </template>
      <v-date-picker
        v-model="dates"
        scrollable
        range
        :allowed-dates="allowedDates"
        @input="chosedDate()"
      >
        <v-spacer></v-spacer>
        <v-btn text color="primary" @click="close()"> Zamknij </v-btn>
      </v-date-picker>
    </v-dialog>
  </v-col>
</template>
<script>
import moment from "moment";
import store from "../../store/index";
export default {
  data() {
    return {
      modal: false,
      dates: null,
    };
  },
  methods: {
    allowedDates: (val) => moment(val).day() != 0 && moment(val).day() != 6,
    chosedDate() {
      this.dates[1] = moment(this.dates[0]).add(7, "days").format("YYYY-MM-DD");
    },
    close() {
      store.commit("setUsersStart", this.dates[0]);
      store.commit("setUsersStop", this.dates[1]);
      this.$emit("changedDates");
      this.modal = false;
    },
  },
};
</script>
