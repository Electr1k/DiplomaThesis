<template>
  <div>
    <h3>Роли</h3>
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
        :items-per-page="10"
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
import SearchField from "@/components/SearchField.vue";

export default {
  name: "RolesView",
  components: { SearchField },
  data() {
    return {
      headers: [
        {
          text: 'ID',
          sortable: false,
          value: 'id',
        },
        {
          text: 'Название',
          sortable: false,
          value: 'name',
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
      const response = await $api.roles.index();
      if (response.data && response.data.data) {
        this.items = response.data.data
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
  },

  methods: {
    editItem(item) {
      this.$router.push({ name: `${this.$route.name}-edit`, params: { id: item.id } })
    },
    async deleteItem(item) {
      try {
        await $api.roles.delete(item.id)
        this.$toast.success('Роль успешно удалена')
      }
      catch(e){
        this.$toast.error(e.message);
      }
      finally {
        const response = await $api.roles.index();
        if (response.data && response.data.data) {
          this.items = response.data.data
        }
      }
    },
    async updateSearch(){
      try {
        const response = await $api.roles.index(this.search);
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
