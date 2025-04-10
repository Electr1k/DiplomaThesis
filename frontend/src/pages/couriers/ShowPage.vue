<template>
  <div>
    <v-card>
      <v-card-title class="display-1 mb-2">Информация о клиенте</v-card-title>

      <v-card-text>
        <v-row>
          <v-col mr="6">
            <v-text-field
                v-model="data.name"
                label="Имя"
                readonly
                outlined
                dense
            />
          </v-col>
          <v-col mr="6">
            <v-text-field
                v-model="data.surname"
                label="Фамилия"
                readonly
                outlined
                dense
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col md="6">
            <v-text-field
                v-model="data.middle_name"
                label="Отчество"
                readonly
                outlined
                dense
            />
          </v-col>
          <v-col md="6">
            <v-text-field
                v-model="data.phone"
                label="Номер"
                readonly
                outlined
                dense
            />
          </v-col>
        </v-row>


        <v-row>
          <v-col md="6">
            <v-text-field
                v-model="data.status"
                label="Статус"
                readonly
                outlined
                dense
            />
          </v-col>
          <v-col md="6">
            <v-text-field
                v-model="data.orders_completed_count"
                label="Количество заказов"
                readonly
                outlined
                dense
            />
          </v-col>
        </v-row>



        <v-row>
          <v-col md="4">
            <v-text-field
                v-model="data.sum_orders"
                label="Сумма за заказы"
                readonly
                outlined
                dense
                class="green-text"
            />
          </v-col>

          <v-col md="4">
            <v-text-field
                v-model="data.sum_bonus"
                label="Сумма бонусов"
                readonly
                outlined
                dense
                class="green-text"
            />
          </v-col>

          <v-col md="4">
            <v-text-field
                v-model="data.sum_fine"
                label="Сумма штрафов"
                class="red-text"
                readonly
                outlined
                dense
            />
          </v-col>
        </v-row>

        <v-divider class="mb-6"></v-divider>

        <v-row>
          <v-col md="4">
            <v-text-field
              v-model="data.last_order_datetime"
              label="Дата последнего заказа"
              readonly
              outlined
              dense
            />
          </v-col>

          <v-col md="4">
            <v-text-field
              v-model="data.first_order_datetime"
              label="Дата первого заказа"
              readonly
              outlined
              dense
            />
          </v-col>
          <v-col md="4">
            <v-text-field
                v-model="data.registered_datetime"
                label="Дата регистрации"
                readonly
                outlined
                dense
            />
          </v-col>
        </v-row>

      </v-card-text>

    </v-card>
  </div>

</template>

<script>
import {$api} from "@/api";

export default {
  name: 'ShowPage',
  computed: {
    modelId: function () {
      return this.$route.params.id
    }
  },
  data() {
    return {
      data: {}
    }
  },
  async created() {
    await this.init()
  },
  methods: {
    async init() {
      try {
        const courier = await $api.couriers.get(this.modelId)
        this.data = courier.data.data || {}
      } catch (error) {
        this.$toast.error(error.response.status === 404 ? 'Клиент не найдет' : 'Произошла ошибка')
      }
    },
  }
}
</script>
<style>

.green-text input {
  color: green !important;
}

.red-text input {
  color: red !important;
}
</style>
