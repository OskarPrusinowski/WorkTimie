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
          Stwórz użytkownika
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          Stwórz użytkownika
        </v-card-title>
        <v-divider></v-divider>

        <v-col class="ma-0 pb-0 pt-0" md="10">
          <v-text-field
            label="Imie"
            outlined
            v-model="user.name"
            :rules="[rules.required, rules.min, rules.max]"
          ></v-text-field>
        </v-col>
        <v-col class="ma-0 pb-0 pt-0" md="10">
          <v-text-field
            label="Nazwisko"
            outlined
            v-model="user.surname"
            :rules="[rules.required, rules.min, rules.max]"
          ></v-text-field>
        </v-col>
        <v-col class="ma-0 pb-0 pt-0" md="10">
          <v-text-field
            label="Numer telefonu"
            outlined
            v-model="user.phone_number"
            :rules="[rules.required, rules.phoneNumber]"
          ></v-text-field>
        </v-col>
        <v-col md="10">
          <v-text-field
            label="Email"
            outlined
            v-model="user.email"
            :rules="[rules.required, rules.email]"
          ></v-text-field>
        </v-col>
        <v-col class="ma-0 pb-0 pt-0" md="10">
          <v-text-field
            label="Hasło"
            outlined
            :type="'password'"
            v-model="user.password"
            :rules="[rules.required, rules.min, rules.max]"
          ></v-text-field>
        </v-col>
        <v-col class="ma-0 pb-0 pt-2" md="10">
          <v-row justify="center">
            <legend
              class="v-label theme--light"
              style="left: 0px; right: auto; position: relative"
            >
              Rozpoczęcie zatrudnienia
            </legend>
            <v-date-picker v-model="user.date_start_employment"></v-date-picker>
          </v-row>
        </v-col>

        <v-col class="ma-0 pb-0 pt-0" md="10">
          <v-select
            v-if="groups"
            :items="groups"
            label="Wybierz grupę"
            item-text="name"
            item-value="id"
            outlined
            v-model="user.group_id"
          ></v-select>
        </v-col>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn depressed color="error" @click="dialog = false">
            Anuluj
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn depressed color="primary" @click="createUser(user)">
            Stwórz użytkownika
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import store from "../../store/index";
export default {
  data() {
    return {
      dialog: false,
      show1: true,
      picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10),
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
    user() {
      return store.getters.getUser;
    },
    groups() {
      return store.getters.getGroups;
    },
  },
  methods: {
    createUser(user) {
      store.commit("setUser", user);
      store.dispatch("createUser", this);
      this.dialog = false;
      this.$emit("added");
    },
    getGroups() {
      store.dispatch("getGroups", this);
    },
    open() {
      store.dispatch("fetchUserInit");
      store.commit("setUserDateStartEmployment", this.picker);
      this.getGroups();
    },
  },
  watch: {
    dialog() {
      this.$refs.form.reset();
    },
  },
};
</script>
