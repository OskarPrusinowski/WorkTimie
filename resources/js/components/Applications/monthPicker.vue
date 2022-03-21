<template>
  <div>
    <v-btn @click="prev()"> <v-icon>mdi-chevron-left</v-icon></v-btn>
    {{ month }}
    <v-btn @click="next()"> <v-icon>mdi-chevron-right</v-icon></v-btn>
  </div>
</template>
<script>
import store from "../../store/index";
import moment from "moment";
export default {
  data() {
    return {
      moment: moment,
    };
  },
  computed: {
    month() {
      return store.getters.getApplicationsMonth;
    },
  },
  methods: {
    prev() {
      store.commit(
        "setApplicationsMonth",
        this.moment(this.month).subtract(1, "months").format("YYYY-MM")
      );
      store.dispatch("getApplications", this);
    },
    next() {
      store.commit(
        "setApplicationsMonth",
        this.moment(this.month).add(1, "months").format("YYYY-MM")
      );
      store.dispatch("getApplications", this);
    },
  },
  created() {},
};
</script>