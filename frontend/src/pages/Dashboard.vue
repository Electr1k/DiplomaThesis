<template>
  <div class="dashboard">
    <v-subheader class="py-0 d-flex justify-space-between rounded-lg">
      <h3>Главная</h3>
    </v-subheader>
    <br>
    <v-col cols="12" >
      <v-card>
        <v-card-title>Количество заказов за последний 10 дней</v-card-title>

        <v-sparkline
          :value="orders"
          :gradient="['#f72047', '#ffd200', '#1feaea']"
          :line-width="2"
          padding="8"
          stroke-linecap="round"
          smooth
          auto-draw

          show-labels

          auto-draw-easing="cubic-bezier(0.4, 0, 0.2, 1)"
        >
        </v-sparkline>
      </v-card>
    </v-col>
  </div>
</template>

<script>
import {$api} from "@/api";

export default {
  name: "DashboardView",
  data() {
    return {
      orders: []
    }
  },

  async created() {
    try {
      const response = await $api.dashboard.orders();
      console.log(response)
      if (response.data && response.data.data) {
        this.orders = response.data.data.map((item) => item.count)
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
  },
}
</script>

