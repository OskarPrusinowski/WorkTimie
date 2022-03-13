<template>
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
        {{ holiday }}
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
            <v-row justify="center">
              <legend
                class="v-label theme--light"
                style="left: 0px; right: auto; position: relative"
              >
                Data
              </legend>
              <v-date-picker v-model="holiday.date"></v-date-picker>
            </v-row>
          </v-col>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="createHoliday()">
            I accept
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import store from "../../store/index";
export default {
  computed: {
    holiday() {
      return store.getters.getHoliday;
    },
  },
  data() {
    return {
      dialog: false,
      rules: {
        required: (value) => !!value || "Wymagane.",
        max: (value) => value.length <= 20 || "Musi zawierać do 20 liter",
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
      picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10),
    };
  },
  methods: {
    createHoliday() {
      store.dispatch("createHoliday", this);
      this.dialog = false;
      this.$emit("added");
    },
    async open() {
      await store.dispatch("setHolidayInit");
      store.commit("setHolidayDate", this.picker);
    },
  },
};
</script>