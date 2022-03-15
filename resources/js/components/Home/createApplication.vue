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
            Zgłoś nadgodziny
          </v-btn>
        </template>

        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Stwórz wniosek
          </v-card-title>

          <v-card-text>
            <v-col class="ma-0 mt-4 pb-0 pt-0" md="10">
              <v-text-field
                label="Typ"
                outlined
                v-model="application.type"
                :rules="[rules.required, rules.min, rules.max]"
              ></v-text-field>
            </v-col>
            <v-col class="ma-0 pb-0 pt-0" md="10">
              <v-date-picker
                v-model="picker"
                :min="moment().add(1, 'days').format('YYYY-MM-DD')"
                :max="moment().add(1, 'months').format('YYYY-MM-DD')"
              ></v-date-picker>
            </v-col>
            <v-col class="ma-0 pb-0 pt-0" md="10">
              <v-textarea
                outlined
                name="Komentarz"
                label="Komentarz"
                v-model="application.comment"
              ></v-textarea>
            </v-col>
            <v-col class="ma-0 pb-0 pt-0" md="10">
              <v-select
                :items="hours"
                item-text="hour"
                item-value="minutes"
                label="Ilość godzin"
                v-model="application.minutes"
              ></v-select>
            </v-col>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn depressed color="primary" @click="create()">
              Złóż wniosek
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
  </v-form>
</template>
<script>
import store from "../../store/index";
import moment from "moment";
export default {
  props: ["userId"],
  data() {
    return {
      moment: moment,
      dialog: false,
      picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10),
      hours: [
        { hour: 1, minutes: 60 },
        { hour: 2, minutes: 120 },
        { hour: 3, minutes: 180 },
        { hour: 4, minutes: 240 },
      ],
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
  computed: {
    application() {
      return store.getters.getApplication;
    },
  },
  methods: {
    open() {},
    create() {
      store.commit("setApplicationChangedDate", this.picker);
      store.commit("setApplicationUserId", this.userId);
      store.dispatch("createApplication", this);
      this.dialog = false;
    },
  },
  watch: {
    dialog() {
      this.$refs.form.reset();
    },
  },
};
</script>