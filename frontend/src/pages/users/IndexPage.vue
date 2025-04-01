<template>
  <div class="dashboard">
    <v-subheader class="py-0 d-flex justify-space-between rounded-lg">
      <h3>Пользователи</h3>
    </v-subheader>
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

export default {
  name: "UsersIndexPage",

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
          text: 'Роль',
          sortable: false,
          value: 'role.name',
        },
        {
          text: '',
          value: 'actions',
          sortable: false,
        }
      ],
      items: []
    }
  },

  async created() {
    try {
      const response = await $api.users.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error('Произошла ошибка:', e.message);
    }
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
    }
  }
}
</script>
