<template>
  <v-form ref="form">
    <div class="text-center">
      <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="red lighten-2"
            dark
            v-bind="attrs"
            v-on="on"
            @click="open()"
          >
            Dodaj dzień wolny
          </v-btn>
        </template>

        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Dodaj dzień wolny
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-col class="ma-0 pb-0 pt-0" md="10">
              <v-text-field
                label="Nazwa"
                outlined
                v-model="holiday.name"
                :rules="[rules.required, rules.min, rules.max]"
              ></v-text-field>
            </v-col>
            <v-col class="ma-0 pb-0 pt-2" md="10">
              <v-menu
                v-model="menu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="auto"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="holiday.date"
                    label="Wybierz datę"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="holiday.date"
                  no-title
                  scrollable
                  min="2010-01-01"
                  max="2030-12-30"
                >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="menu = false"> OK </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-btn depressed color="error" @click="dialog = false">
              Anuluj
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" depressed @click="createHoliday()">
              Dodaj
            </v-btn>
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
  computed: {
    holiday() {
      return store.getters.getHoliday;
    },
  },
  data() {
    return {
      dialog: false,
      menu: false,
      rules: {
        required: (value) => !!value || "Wymagane.",
        max: (value) => value.length <= 40 || "Musi zawierać do 40 liter",
        min: (value) => 4 <= value.length || "Musi zawierać od 4 liter",
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
      picker: moment().format("YYYY-MM-DD"),
    };
  },
  methods: {
    createHoliday() {
      if (this.$refs.form.validate()) {
        store.dispatch("createHoliday", this);
        if (
          moment(this.holiday.date).day() == 0 ||
          moment(this.holiday.date).day() == 6
        ) {
          store.dispatch("increaseCounterHolidays", this);
        }
        this.dialog = false;
        this.$emit("added");
      }
    },
    async open() {
      await store.dispatch("setHolidayInit");
      store.commit("setHolidayDate", this.picker);
    },
  },
  watch: {
    dialog() {
      this.$refs.form.reset();
    },
  },
};
</script>
