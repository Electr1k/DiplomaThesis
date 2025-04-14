<template>
  <div class="dashboard">
    <v-subheader class="py-0 d-flex justify-space-between rounded-lg">
      <h3>Главная</h3>
    </v-subheader>
    <br>
    <v-row
      >

    <v-col cols="6">
      <v-card>
        <v-card-title>Количество заказов за последние 10 дней</v-card-title>

          <v-sparkline
              :value="orders"
              :gradient="['#1feaea', '#ffd200', '#f72047',]"
              :line-width="2"
              :labels="order_labels"
              padding="12"
              stroke-linecap="round"
              smooth
              auto-draw
              label-size="4"
          ></v-sparkline>
      </v-card>
    </v-col>
      <v-col cols="6">
      <v-card >
        <v-card-title>Количество новых клиентов</v-card-title>

        <v-sparkline
            :value="clients"
            :gradient="['#1feaea', '#ffd200', '#f72047',]"
            :line-width="2"
            :labels="client_labels"
            padding="12"
            stroke-linecap="round"
            smooth
            auto-draw
            label-size="4"
        ></v-sparkline>
      </v-card>
    </v-col>
    </v-row>

  </div>
</template>

<script>
import {$api} from "@/api";

export default {
  name: "DashboardView",
  data() {
    return {
      orders: [],
      order_labels: [],
      clients: [],
      client_labels: [],
    };
  },
  async created() {
    try {
      const response = await $api.dashboard.orders();
      if (response.data?.data) {
        this.orders = []
        this.order_labels = []
        response.data.data.map(item => {
          this.orders.push(item.count)
          const date = new Date(item.date);
          const day = String(date.getDate()).padStart(2, '0');
          const month = String(date.getMonth() + 1).padStart(2, '0');
          this.order_labels.push(`${item.count} (${day}-${month})`)
        });
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
    try{
      const response = await $api.dashboard.newClients();
      if (response.data?.data) {
        this.clients = []
        this.client_labels = []
        response.data.data.map(item => {
          this.clients.push(item.count)
          const date = new Date(item.date);
          const day = String(date.getDate()).padStart(2, '0');
          const month = String(date.getMonth() + 1).padStart(2, '0');
          this.client_labels.push(`${item.count} (${day}-${month})`)
        });
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
  },
};
</script>
