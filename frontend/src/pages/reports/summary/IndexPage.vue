<template>
  <div>
    <h3>Сводный отчет</h3>
    <br>

    <v-card>
      <v-data-table
        :headers="headers"
        :items-per-page="15"
        :items="items"
        :footer-props="{
          'items-per-page-text': 'Строк на странице:',
          'items-per-page-options': [10, 25, 50, -1],
          'items-per-page-all-text': 'Все',
          'page-text': '{0}-{1} из {2}'
        }"
        :loading="loading"
        class="elevation-1"
        loading-text="Загрузка..."
        no-data-text="Ничего не найдено"
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
        },
        {
          text: 'Количество заказов',
          sortable: false,
          value: 'orders_count',
        },
        {
          text: 'Количество активных курьеров',
          sortable: false,
          value: 'active_courier_count',
        },
        {
          text: 'Количество новых курьеров',
          sortable: false,
          value: 'new_courier_count',
        },
        {
          text: 'Оборот заказов',
          sortable: false,
          value: 'orders_amount',
          cellClass: 'green-column',
        },
        {
          text: 'Сумма бонусов',
          sortable: false,
          value: 'bonus_amount',
        },
        {
          text: 'Сумма штрафов',
          sortable: false,
          value: 'fine_amount',
          cellClass: 'red-column',
        },
      ],
      items: [],
      loading: true
    }
  },

  async created() {
    try {
      this.loading = true
      const response = await $api.summaryReport.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
    this.loading = false
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
