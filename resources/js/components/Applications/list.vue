<template>
  <div>
    <v-simple-table>
      <thead>
        <tr>
          <th class="text-left">Lp</th>
          <th class="text-left">Użytkownik</th>
          <th class="text-left">Typ</th>
          <th class="text-left">Data wysłania</th>
          <th class="text-left">Data</th>
          <th class="text-left">Ilość godzin</th>
          <th class="text-left">Komentarz</th>
          <th class="text-left">Status</th>
          <th class="text-left">Akceptuj</th>
          <th class="text-left">Odrzuć</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(application, index) in applications" :key="application.id">
          <td class="text-left">{{ index + 1 }}</td>
          <td class="text-left">{{ application.user.name }}</td>
          <td class="text-left">{{ application.type }}</td>
          <td class="text-left">{{ application.date }}</td>
          <td class="text-left">{{ application.changed_date }}</td>
          <td class="text-left">{{ application.minutes / 60 }}</td>
          <td class="text-left">{{ application.comment }}</td>
          <td class="text-left">{{ application.status }}</td>
          <td class="text-left">
            <v-btn
              @click="accept(application.id)"
              :disabled="application.acceptation_date"
            >
              <v-icon>mdi-check-bold </v-icon>
            </v-btn>
          </td>
          <td class="text-left">
            <v-btn
              @click="rejct(application.id)"
              :disabled="application.acceptation_date"
            >
              <v-icon> mdi-close-thick </v-icon>
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
import store from "../../store/index";
export default {
  computed: {
    applications() {
      return store.getters.getApplications;
    },
    user() {
      return store.getters.getActualUser;
    },
  },
  methods: {
    accept(id) {
      store.commit("setApplicationAccepted", true);
      this.considerApplication(id);
    },
    reject(id) {
      store.commit("setApplicationAccepted", false);
      this.considerApplication(id);
    },
    considerApplication(id) {
      store.commit("setApplicationId", id);
      store.commit("setAcceptationId", this.user.id);
      store.dispatch("considerApplcation", this);
    },
  },
  created() {
    store.dispatch("getApplications", this);
  },
};
</script>