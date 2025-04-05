<template>
  <div>
    <h3>Сводный отчет</h3>
    <br>

    <v-card>
      <v-data-table
        :headers="headers"
        :items-per-page="15"
        :items="items"
        class="elevation-1"
      >
        <template v-for="(_, slot) in $scopedSlots" v-slot:[slot]="scope">
          <slot :name="slot" v-bind="scope"/>
        </template>


      </v-data-table>
    </v-card>
  </div>
</template>

<script>
import {$api} from "@/api";

export default {
  name: "RolesView",

  data() {
    return {
      headers: [
        {
          text: 'Дата',
          sortable: false,
          value: 'date',
          align: 'center',
        },
        {
          text: 'Количество заказов',
          sortable: false,
          value: 'orders_count',
          align: 'center',
        },
        {
          text: 'Количество активных курьеров',
          sortable: false,
          value: 'active_courier_count',
          align: 'center',
        },
        {
          text: 'Количество новых курьеров',
          sortable: false,
          value: 'new_courier_count',
          align: 'center',
        },
        {
          text: 'Оборот заказов',
          sortable: false,
          value: 'orders_amount',
          cellClass: 'green-column',
          align: 'center',
        },
        {
          text: 'Сумма бонусов',
          sortable: false,
          value: 'bonus_amount',
          align: 'center',
        },
        {
          text: 'Сумма штрафов',
          sortable: false,
          value: 'fine_amount',
          align: 'center',
          cellClass: 'red-column',
        },
      ],
      items: []
    }
  },

  async created() {
    try {
      const response = await $api.summaryReport.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error('Произошла ошибка:', e.message);
    }
  },
}
</script>

<style>
.green-column {
  color: darkgreen; /* цвет текста */
}
</style>

<style>
.red-column {
  color: darkred; /* цвет текста */
}
</style>
