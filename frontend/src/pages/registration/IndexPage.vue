<template>
  <div>
    <h3>Регистрации</h3>
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
import SearchField from "@/components/SearchField.vue";

export default {
  name: "RegistrationIndexPage",
  components: {SearchField},

  data() {
    return {
      headers: [
        {
          text: 'ID регистрации',
          sortable: false,
          value: 'id',
        },
        {
          text: 'Дата регистрации',
          sortable: false,
          value: 'created_at',
          align: 'center',
        },
        {
          text: 'Статус',
          sortable: false,
          value: 'status',
          align: 'center',
        },
        {
          text: 'Кабинет',
          sortable: false,
          value: 'cabinet.region_name',
          align: 'center',
        },
        {
          text: 'Имя',
          sortable: false,
          value: 'name',
          align: 'center',
        },
        {
          text: 'Фамилия',
          sortable: false,
          value: 'surname',
          align: 'center',
        },
        {
          text: 'Отчество',
          sortable: false,
          value: 'middle_name',
          align: 'center',
        },
        {
          text: 'Номер',
          sortable: false,
          value: 'phone',
          align: 'center',
        },

        {
          value: 'actions',
          sortable: false,
        }
      ],
      items: [],
      search: ""
    }
  },

  async created() {
    try {
      const response = await $api.registrations.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
  },

  methods: {
    showItem(item) {
      this.$router.push({ name: `${this.$route.name}-edit`, params: { id: item.id } })
    },
    async updateSearch(){
      try {
        const response = await $api.registrations.index(this.search);
        if (response.data && response.data.data) {
          this.items = response.data.data
        }
      }
      catch (e) {
        this.$toast.error(e.message);
      }
    }
  }
}
</script>
