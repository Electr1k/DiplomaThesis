<template>
  <div>
    <h3>Регистрации</h3>
    <br>

    <v-row align="center">
      <v-col md="4">
        <SearchField v-model="search" @keydown.enter="updateSearch()" />
      </v-col>
      <v-col md="3">
        <v-autocomplete
            :items="users"
            :value="selectedUser"
            @change="updatedSelectUser"
            chips
            item-text="name"
            item-value="id"
            label="Ответственный"
        >
          <template v-slot:item="{ item }">
            <v-list-item-avatar >
              <v-img :src="item.image" />
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>{{ item.name }} {{ item.surname }}</v-list-item-title>
            </v-list-item-content>
          </template>

          <template v-slot:selection="{ item }">
            <v-chip  outlined
                     pill color="primary" close @click:close="clearUser">
              <v-avatar left>
                <v-img :src="item.image" />
              </v-avatar>
              {{ item.name }} {{ item.surname }}
            </v-chip>
          </template>
        </v-autocomplete>
      </v-col>

      <v-col md="3">
        <v-autocomplete
            :items="statuses"
            :value="selectedStatus"
            @change="updatedSelectStatus"
            chips
            item-text="name"
            item-value="value"
            label="Статус"
        >
          <template v-slot:item="{ item }">
            <v-list-item-title>
              {{ item.name }}
            </v-list-item-title>
            </template>

          <template v-slot:selection="{ item }">
            <v-chip :color="item.color" close @click:close="clearStatus">
              {{ item.name }}
            </v-chip>
          </template>
        </v-autocomplete>
      </v-col>

    </v-row>
    <br>

    <v-card>
      <v-data-table
        :headers="headers"
        :items-per-page="15"
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

        <template v-slot:[`item.status`]="{ item }">
          <span :class="{
            'green--text': item.status_code === 'created',
            'red--text': item.status_code === 'failed' || item.status_code === 'closed',
            'orange--text': item.status_code === 'new',
            'blue--text': item.status_code === 'waiting',
          }">
              {{ item.status }}
          </span>
        </template>

        <template v-slot:[`item.user`]="{ item }">
          <v-col class="text-center" v-if="item.user">
            <v-avatar class="mr-1" color="grey darken-1" size="35" >
              <v-img :src=item.user.image />
            </v-avatar>
            <span class="black--text">{{ item.user.name }}</span>
          </v-col>
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
          text: 'Номер',
          sortable: false,
          value: 'id',
        },
        {
          text: 'Дата регистрации',
          sortable: false,
          value: 'created_at',
        },
        {
          text: 'Статус',
          sortable: false,
          value: 'status',
        },
        {
          text: 'Кабинет',
          sortable: false,
          value: 'cabinet.region_name',
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
          text: 'Ответственный',
          sortable: false,
          value: 'user',
        },
        {
          value: 'actions',
          sortable: false,
        }
      ],
      items: [],
      users: [],
      statuses: [{ name: 'Ошибка', value: 'failed', color: 'error' }, { name: 'Ожидает подтверждения', value: 'waiting', color: 'warning' }, { name: 'Ожидает создания', value: 'new', color: 'primary' }, { name: 'Успешно создан', value: 'created', color: 'success' }, { name: 'Отклонено', value: 'closed', color: 'error' }],
      selectedStatus: null,
      selectedUser: null,
      search: "",
      loading: true
    }
  },

  async created() {
    try {
      this.loading = true
      const response = await $api.registrations.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
    this.loading = false

    try {
      const response = await $api.users.index();
      if (response.data && response.data.data) {
        this.users = response.data.data
      }
    } catch (e){e;}
  },

  methods: {
    showItem(item) {
      this.$router.push({ name: `${this.$route.name}-edit`, params: { id: item.id } })
    },
    async updateSearch(){
      try {
        this.loading = true
        const response = await $api.registrations.index({search: this.search, user_id: this.selectedUser, status: this.selectedStatus});
        if (response.data && response.data.data) {
          this.items = response.data.data
        }
      }
      catch (e) {
        this.$toast.error(e.message);
      }
      this.loading = false
    },
    async updatedSelectUser(item){
      this.selectedUser = item
      await this.updateSearch()
    },
    async updatedSelectStatus(item){
      this.selectedStatus = item
      await this.updateSearch()
    },
    async clearUser(){
      this.selectedUser = null
      await this.updateSearch()
    },
    async clearStatus(){
      this.selectedStatus = null
      await this.updateSearch()
    },
  }
}
</script>
