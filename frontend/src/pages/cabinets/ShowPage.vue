<template>
  <div>
    <v-card>
      <v-card-title class="display-1 mb-2">Информация о кабинете партнера</v-card-title>

      <v-card-text>
        <v-row>
          <v-col md="6">
            <v-text-field
                v-model="data.region_name"
                label="Регион"
                readonly
                outlined
                dense
            />
          </v-col>
          <v-col md="6">
            <v-text-field
                v-model="data.legal_name"
                label="Наименование юридического лица"
                readonly
                outlined
                dense
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col md="6">
            <v-text-field
                v-model="data.vehicle_type_name"
                label="Тип транспорта"
                readonly
                outlined
                dense
            />
          </v-col>
          <v-col md="6">
            <v-text-field
                v-model="data.partner_commission_part"
                label="Процент комиссии"
                readonly
                outlined
                dense
            />
          </v-col>
        </v-row>


        <v-row>
          <v-col md="6">
            <v-text-field
                :value="data.is_for_taking_available_couriers ? 'Да' : 'Нет'"
                label="Особый кабинет для особых курьеров"
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
        const courier = await $api.cabinets.get(this.modelId)
        this.data = courier.data.data || {}
      } catch (error) {
        this.$toast.error(error.response.status === 404 ? 'Кабинет не найдет' : 'Произошла ошибка')
      }
    },
  }
}
</script>
