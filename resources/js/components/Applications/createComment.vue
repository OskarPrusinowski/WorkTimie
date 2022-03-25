<template>
  <div class="text-center mt-2">
    <v-dialog v-model="dialog" width="500" @click:outside="close()">
      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          Dodaj komentarz
        </v-card-title>

        <v-card-text>
          <v-col class="ma-0 pb-0 pt-0" md="10">
            <v-textarea
              outlined
              name="Komentarz"
              label="Komentarz"
              v-model="comment"
            ></v-textarea>
          </v-col>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="update(comment)"> Dodaj </v-btn>
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
      comment: "",
    };
  },
  props: ["dialog"],
  methods: {
    close() {
      this.$emit("closed");
    },
    update(comment) {
      store.commit("setApplicationAcceptationComment", comment);
      this.close();
    },
  },
  created() {
    this.comment = "";
    store.commit("setApplicationAcceptationComment", "");
  },
};
</script>