<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="red lighten-2" dark v-bind="attrs" v-on="on">
          Szczegóły
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          Privacy Policy
        </v-card-title>

        <v-card-text>
          <v-simple-table>
            <thead>
              <tr>
                <th>Lp</th>
                <th>Typ</th>
                <th>Start</th>
                <th>Czas</th>
                <th>Stop</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(workPeriod, index) in workPeriods"
                :key="workPeriod.id"
              >
                <td>{{ index + 1 }}</td>
                <td>{{ workPeriod.type }}</td>
                <td>{{ moment(workPeriod.start).format("H:mm:ss") }}</td>
                <td v-if="workPeriod.stop">
                  {{
                    moment
                      .utc(
                        moment(workPeriod.stop).diff(moment(workPeriod.start))
                      )
                      .format("HH:mm")
                  }}
                </td>
                <td v-else>
                  {{
                    moment
                      .utc(moment().diff(moment(workPeriod.start)))
                      .format("HH:mm")
                  }}
                </td>
                <td v-if="workPeriod.stop">
                  {{ moment(workPeriod.stop).format("H:mm:ss") }}
                </td>
                <td v-else></td>
              </tr>
            </tbody>
          </v-simple-table>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="dialog = false"> Zamknij </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment from "moment";
export default {
  props: ["workPeriods"],
  data() {
    return {
      dialog: false,
      moment: moment,
    };
  },
};
</script>