<template>
  <div>
    <h3>Кабинеты партнеров</h3>
    <br>

    <v-row>
      <v-col md="4">
        <SearchField v-model="search" @keydown.enter="updateSearch()" />
      </v-col>
    </v-row>
    <br>

    <v-card>
      <v-data-table
        :headers="headers"
        :items="items"
        :loading="loading"
        :footer-props="{
          'items-per-page-text': 'Строк на странице:',
          'items-per-page-options': [10, 25, 50, -1],
          'items-per-page-all-text': 'Все',
          'page-text': '{0}-{1} из {2}'
        }"
        loading-text="Загрузка..."
        no-data-text="Ничего не найдено"
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
import SearchField from "@/components/SearchField.vue";

export default {
  name: "CabinetsIndexPage",
  components: {SearchField},

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
      items: [],
      search: "",
      loading: true
    }
  },

  async created() {
    try {
      this.loading = true
      const response = await $api.cabinets.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
    this.loading = false
  },

  methods: {
    showItem(item) {
      this.$router.push({ name: `${this.$route.name}-show`, params: { id: item.courier_partner_id } })
    },
    async updateSearch(){
      try {
        this.loading = true
        const response = await $api.cabinets.index({search: this.search});
        if (response.data && response.data.data) {
          this.items = response.data.data
        }
      }
      catch (e) {
        this.$toast.error(e.message);
      }
      this.loading = false
    }
  }
}
</script>
