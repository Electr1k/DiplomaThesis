  <template>
    <v-tabs
        v-model="tab"
    >
      <v-tab>Данные сотрудника</v-tab>
      <v-tab>Клиенты</v-tab>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <user-form
              :key="userId"
              :model-id="userId"
              @submit="onSubmit"
              @cancel="$router.back()"
          />
        </v-tab-item>
        <v-tab-item>
          <v-card>
            <v-data-table
                :headers="headers"
                :items-per-page="15"
                :items="clients"
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
                    'red--text': item.status_code === 'failed',
                    'orange--text': item.status_code === 'new'
                  }">
                    {{ item.status }}
                </span>
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
        </v-tab-item>
      </v-tabs-items>
    </v-tabs>
  </template>

  <script>
  import UserForm from '../../components/UserForm.vue'
  import {$api} from "@/api";

  export default {
    components: {
      UserForm
    },
    data () {
      return {
        user: null,
        loading: false,
        tab: 0,
        headers: [
          {
            text: 'Номер',
            sortable: false,
            value: 'id',
            align: 'center',
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
            value: 'actions',
            sortable: false,
          }
        ],
        clients: []
      }
    },
    async created() {
      try {
        this.loading = true
        const response = await $api.registrations.index({user_id: this.userId});
        if (response.data && response.data.data) {
          this.clients = response.data.data
        }
      } catch (e) {
        this.$toast.error(e.message);
      }
      this.loading = false
    },
    computed: {
      userId: function () {
        return this.$route.params.id
      }
    },

    methods: {
      onSubmit () {
        this.$toast.success('Данные успешно изменены')
        this.$router.push({ name: 'users' })
      },
      showItem(item) {
        this.$router.push({ name: 'registrations-edit', params: { id: item.id } })
      },
    }
  }
  </script>
