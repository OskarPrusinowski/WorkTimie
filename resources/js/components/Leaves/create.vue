<template>
  <v-form ref="form">
    <div class="text-center">
      <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
          <v-btn color="red lighten-2" dark v-bind="attrs" v-on="on">
            Stwórz wniosek o urlop
          </v-btn>
        </template>

        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Stwórz wniosek
          </v-card-title>

          <v-card-text>
            <v-col class="ma-0 pb-0 pt-0" md="10">
              <v-menu
                v-model="menu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="auto"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="dates"
                    label="Wybierz datę"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    :rules="rules.required"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dates"
                  no-title
                  scrollable
                  :allowed-dates="allowedDates"
                  :min="minDate"
                  range
                >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="menu = false"> OK </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
          </v-card-text>
          <v-col class="ma-0 pb-0 pt-0" md="10">
            <v-textarea
              outlined
              name="Komentarz"
              label="Komentarz"
              v-model="application.comment"
            ></v-textarea>
          </v-col>
          <v-divider></v-divider>

          <v-card-actions>
            <v-btn depressed color="error" @click="dialog = false">
              Zamknij
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn depressed color="primary" @click="create()"> Stwórz </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div></v-form
  >
</template>

<script>
import store from "../../store/index";
import moment from "moment";
export default {
  props: ["userId"],
  computed: {
    application() {
      return store.getters.getApplication;
    },
  },
  data() {
    return {
      menu: false,
      minDate: moment().add(1, "days").format("YYYY-MM-DD"),

      dialog: false,
      dates: "",
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
    };
  },
  methods: {
    create() {
      if (this.$refs.form.validate()) {
        store.commit("setApplicationUserId", this.userId);
        store.commit("setApplicationType", "Urlop");
        if (this.dates[0] == "") {
          this.dates[0] = moment(this.dates[1])
            .subtract(
              parseInt(this.dates[1].substr(this.dates[1].length - 2)) - 1,
              "days"
            )
            .format("YYYY-MM-DD");
        }
        if (this.dates[1] > this.dates[0]) {
          store.commit("setApplicationFirstDate", this.dates[0]);
          store.commit("setApplicationSecondDate", this.dates[1]);
        } else {
          store.commit("setApplicationFirstDate", this.dates[1]);
          store.commit("setApplicationSecondDate", this.dates[0]);
        }
        store.commit("setApplicationMinutes", null);
        store.dispatch("createApplication", this);
        this.dialog = false;
      }
    },
    allowedDates: (val) => moment(val).day() != 0 && moment(val).day() != 6,
  },
  watch: {
    dialog() {
      this.$refs.form.reset();
    },
  },
};
</script>