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
        class="elevation-1"
        loading-text="Загрузка..."
        no-data-text="Ничего не найдено"
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
  name: "UsersIndexPage",
  components: {SearchField},

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
          value: 'name',
        },
        {
          text: 'Фамилия',
          sortable: false,
          value: 'surname',
        },
        {
          text: 'Отчество',
          sortable: false,
          value: 'middle_name',
        },
        {
          text: 'Номер',
          sortable: false,
          value: 'phone',
        },
        {
          text: 'Количество заказов',
          sortable: false,
          value: 'orders_completed_count',
        },
        {
          text: 'Дата регистрации',
          sortable: false,
          value: 'registered_datetime',
        },
        {
          text: 'Дата первого заказа',
          sortable: false,
          value: 'first_order_datetime',
        },
        {
          text: 'Дата последнего заказа',
          sortable: false,
          value: 'last_order_datetime',
        },
        {
          value: 'actions',
          sortable: false,
        }
      ],
      items: [],
      search: "",
      loading: true
    }
  },

  async created() {
    try {
      this.loading = true
      const response = await $api.couriers.index();
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
      this.$router.push({ name: `${this.$route.name}-show`, params: { id: item.courier_id } })
    },
    async updateSearch(){
      try {
        this.loading = true
        const response = await $api.couriers.index({search: this.search});
        if (response.data && response.data.data) {
          this.items = response.data.data
        }
      }
      catch (e) {
        this.$toast.error(e.message);
      }
      this.loading = false
    }
  },
}
</script>
