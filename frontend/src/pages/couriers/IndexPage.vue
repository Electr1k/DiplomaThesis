<template>
  <div>
    <h3>Клиенты</h3>
    <br>

    <v-row>
      <v-col cols="auto">
        <v-btn
          color="primary"
          :to="{ name: `${this.$route.name}-store` }">Создать</v-btn>
      </v-col>
    </v-row>
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

        <template v-slot:[`item.actions`]="{ item }">
          <div class="d-flex justify-end align-center mr-14">
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                icon
                v-bind="attrs"
                v-on="on"
                @click="showItem(item)"
              >
                <v-icon>mdi-eye</v-icon>
              </v-btn>
            </template>
            <span>Информация</span>
          </v-tooltip>

          </div>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
import {$api} from "@/api";

export default {
  name: "UsersIndexPage",

  data() {
    return {
      headers: [
        {
          text: 'ID Курьера',
          sortable: false,
          value: 'courier_id',
        },
        {
          text: 'Имя',
          sortable: false,
          align: 'center',
          value: 'name',
        },
        {
          text: 'Фамилия',
          sortable: false,
          align: 'center',
          value: 'surname',
        },
        {
          text: 'Отчество',
          sortable: false,
          align: 'center',
          value: 'middle_name',
        },
        {
          text: 'Номер',
          sortable: false,
          align: 'center',
          value: 'phone',
        },
        {
          text: 'Количество заказов',
          sortable: false,
          align: 'center',
          value: 'orders_completed_count',
        },
        {
          text: 'Дата регистрации',
          sortable: false,
          align: 'center',
          value: 'registered_datetime',
        },
        {
          text: 'Дата первого заказа',
          sortable: false,
          align: 'center',
          value: 'first_order_datetime',
        },
        {
          text: 'Дата последнего заказа',
          sortable: false,
          align: 'center',
          value: 'last_order_datetime',
        },
        {
          value: 'actions',
          sortable: false,
        }
      ],
      items: []
    }
  },

  async created() {
    try {
      const response = await $api.couriers.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error('Произошла ошибка:', e.message);
    }
  },

  methods: {
    showItem(item) {
      console.log(`${this.$route.name}-show`)
      this.$router.push({ name: `${this.$route.name}-show`, params: { id: item.courier_id } })
    },
  }
}
</script>
