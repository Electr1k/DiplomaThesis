<template>
  <div>
    <h3>Пользователи</h3>
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
        :items-per-page=15
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

        <template v-slot:[`item.name`]="{ item }">
          <v-col class="justify-center">
            <v-avatar class="mr-2" color="grey darken-1" size="35" >
              <v-img :src=item.image />
            </v-avatar>
            <span class="black--text">{{ item.name }}</span>
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
                @click="editItem(item)"
              >
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
            </template>
            <span>Редактировать</span>
          </v-tooltip>

          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                icon
                v-bind="attrs"
                v-on="on"
                color="error"
                @click="deleteItem(item)"
              >
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </template>
            <span>Удалить</span>
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
          text: 'ID',
          sortable: false,
          value: 'id',
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
          text: 'Роль',
          sortable: false,
          value: 'role.name',
        },
        {
          text: 'Email',
          sortable: false,
          value: 'email',
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
      const response = await $api.users.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
    this.loading = false
  },

  methods: {
    editItem(item) {
      this.$router.push({ name: `${this.$route.name}-edit`, params: { id: item.id } })
    },
    async deleteItem(item) {
      try {
        await $api.users.delete(item.id)
        this.$toast.success('Сотрудник успешно удален')
      }
      catch(e){
        this.$toast.error(e.response.data.message)
      }
      finally {
        const response = await $api.users.index();
        if (response.data && response.data.data) {
          this.items = response.data.data
        }
      }
    },
    async updateSearch(){
      try {
        this.loading = true
        const response = await $api.users.index({search: this.search});
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
