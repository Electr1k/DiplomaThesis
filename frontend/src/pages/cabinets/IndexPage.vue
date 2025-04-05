<template>
  <div class="dashboard">
    <v-subheader class="py-0 d-flex justify-space-between rounded-lg">
      <h3>Кабинеты партнеров</h3>
    </v-subheader>
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
  name: "CabinetsIndexPage",

  data() {
    return {
      headers: [
        {
          text: 'ID Кабинета партнера',
          sortable: false,
          value: 'courier_partner_id',
        },
        {
          text: 'Регион',
          sortable: false,
          value: 'region_name',
        },
        {
          text: 'Наименование юридического лица',
          sortable: false,
          value: 'legal_name',
        },
        {
          text: 'Тип транспорта',
          sortable: false,
          value: 'vehicle_type_name',
        },
        {
          text: 'Процент комиссии',
          sortable: false,
          value: 'partner_commission_part',
        },
        {
          sortable: false,
          value: 'actions'
        },

      ],
      items: []
    }
  },

  async created() {
    try {
      const response = await $api.cabinets.index();
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
      this.$router.push({ name: `${this.$route.name}-show`, params: { id: item.courier_partner_id } })
    },
  }
}
</script>
