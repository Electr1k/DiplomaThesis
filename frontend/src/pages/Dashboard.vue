<template>
  <div class="dashboard">
    <v-subheader class="py-0 d-flex justify-space-between rounded-lg">
      <h3>Dashboard</h3>
      <v-btn color="success">
        View Orders
      </v-btn>
    </v-subheader>
    <br>
    <v-row>
      <v-col lg="7" cols="12">
        <v-alert dense text type="success">
          Login Successfully! Welcome to <strong>Web Burden</strong>
        </v-alert>
        <v-row>
          <v-col lg="6" cols="12" v-for="(item,index) in activityLog" :key="index">
            <v-card elevation="2" class="rounded-lg">
              <v-card-text class="d-flex justify-space-between align-center">
                <div>
                  <strong>{{ item.title }}</strong> <br>
                  <span>Last 3 weeks</span>
                </div>
                <v-avatar size="60" :color="item.color" style="border: 3px solid #444">
                  <span style="color: white">{{item.amount}} +</span>
                </v-avatar>
              </v-card-text>
              <v-card-actions class="d-flex justify-space-between">
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="12" lg="5">
        <v-card>
          <v-card-title>Activities</v-card-title>
          <v-card-text class="py-0">
            <v-timeline align-top dense>
              <v-timeline-item color="indigo" small>
                <strong>5 Minutes ago</strong>
                <div class="text-caption">
                  You have new order please check this out
                </div>
              </v-timeline-item>
              <v-timeline-item color="green" small>
                <strong>35 Minutes ago</strong>
                <div class="text-caption mb-2">
                  A Product has been delivered!
                </div>
              </v-timeline-item>
              <v-timeline-item color="indigo" small>
                <strong>44 Minutes ago</strong>
                <div class="text-caption">
                  You have new order please check this out
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col>
        <v-card>
          <v-data-table
              caption="Recent Order list"
              :headers="headers"
              :items="desserts"
              :items-per-page="5"
              class="elevation-1"
          >

          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  name: "DashboardView",
  data() {
    return {
      activityLog: [
        {title: 'Total Products', amount: 50, icon: 'mdi-account', color: 'cyan lighten-3'},
        {title: 'Total Customer', amount: 3433, icon: 'mdi-account-group-outline', color: 'green darken-2'},
        {title: 'Total Sale', amount: 3433, icon: 'mdi-account-group-outline', color: 'blue-grey darken-1'},
        {
          title: 'Pending Orders',
          amount: 3433,
          icon: 'mdi-account-group-outline',
          color: 'deep-orange darken-1'
        },
      ],
      headers: [
        {
          text: 'Dessert (100g serving)',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        {text: 'Calories', value: 'calories'},
        {text: 'Fat (g)', value: 'fat'},
        {text: 'Carbs (g)', value: 'carbs'},
        {text: 'Protein (g)', value: 'protein'},
        {text: 'Iron (%)', value: 'iron'},
        {text: 'Actions', value: 'action', sortable: false},
      ],
      desserts: [
        {
          name: 'Frozen Yogurt',
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
          iron: '1%',
        },
      ],
    }
  },
}
</script>

