<template>
  <v-form ref="form">
    <div class="text-center">
      <v-snackbar v-model="snackbar" :timeout="5000" top color="error">
        <span>Musisz wybrać datę</span>
        <v-divider></v-divider>
      </v-snackbar>
      <v-dialog
        v-model="show"
        width="500"
        @click:outside="outside()"
        persistent
      >
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Wybierz datę do odrobienia {{ Math.floor(minutes / 60) }}
            <strong> godzin</strong>
            <span v-if="minutes % 60">
              {{ minutes % 60 }}
              <strong> minut</strong></span
            >
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-col class="ma-0 mt-2 pb-0 pt-0" md="10">
              <v-menu
                v-model="menu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="auto"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="picker"
                    label="Wybierz datę"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    :rules="[rules.required]"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="picker"
                  no-title
                  scrollable
                  :allowed-dates="allowedDates"
                  :min="minDate"
                  :max="maxDate"
                >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="menu = false"> OK </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn depressed color="primary" @click="create()"> Dodaj </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div></v-form
  >
</template>

<script>
import moment from "moment";
import store from "../../store/index";
export default {
  props: ["show", "minutes"],
  data() {
    return {
      menu: false,
      rules: {
        required: (value) => !!value || "Wymagane.",
        max: (value) => value.length <= 20 || "Musi zawierać do 20 liter",
        min: (value) => 8 <= value.length || "Musi zawierać od 8 liter",
        phoneNumber: (v) => {
          if (!v.trim()) return true;
          if (!isNaN(parseFloat(v)) && v >= 100000000 && v <= 999999999)
            return true;
          return "Liczba musi być numerem telefonu";
        },
        email: (value) => {
          const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Nieprawidłowy email";
        },
        confirmPassword: (value) =>
          this.user.password === value || "Hasła się nie zgadzają",
      },
      picker: "",
      moment: moment,
      minDate: moment().add(1, "days").format("YYYY-MM-DD"),
      maxDate: moment().add(1, "months").format("YYYY-MM-DD"),
      snackbar: false,
    };
  },
  methods: {
    create() {
      if (this.$refs.form.validate()) {
        store.commit("setAdditionalHourDate", this.picker);
        store.dispatch("createAdditionalHour", this);
        this.$emit("closeDialog");
      }
    },
    allowedDates: (val) => moment(val).day() != 0 && moment(val).day() != 6,
    outside() {
      this.snackbar = true;
    },
  },
  created() {},
};
</script>
