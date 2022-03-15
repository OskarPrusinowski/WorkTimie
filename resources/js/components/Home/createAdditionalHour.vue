<template>
  <div class="text-center">
    <v-dialog v-model="show" width="500">
      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          Wybierz datę do odrobienia {{ minutes }} minut
        </v-card-title>

        <v-card-text>
          <v-date-picker
            v-model="picker"
            :min="moment().add(1, 'days').format('YYYY-MM-DD')"
            :max="moment().add(1, 'months').format('YYYY-MM-DD')"
          ></v-date-picker>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn depressed color="primary" @click="create()"> Dodaj </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment from "moment";
import store from "../../store/index";
export default {
  props: ["show", "minutes", "user_id"],
  data() {
    return {
      picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .add(1, "days")
        .toISOString()
        .substr(0, 10),
      moment: moment,
    };
  },
  methods: {
    create() {
      store.commit("setAdditionalHourDate", this.picker);
      store.dispatch("createAdditionalHour", this);
      this.show = false;
    },
  },
  created() {},
};
</script>