<template>
  <div>
    <v-form @submit.prevent="submit">
      <v-card
        :loading="loading"
        :disabled="loading"
      >
        <v-card-title class="display-1 mb-2">
          <span v-if="modelId">Изменение данных</span>
          <span v-else>Создание курьера</span>
        </v-card-title>

        <v-card-text>
          <v-row align="center">
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-autocomplete
                  v-model="form.courier_partner_id"
                  chips
                  :items="courier_partners"
                  item-text="region_name"
                  item-value="courier_partner_id"
                  :label="'Кабинет патнера'"
                  :error-messages="form.errors.get(`courier_partner_id`)"
              />
            </v-col>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                  v-model="form.phone"
                  :error-messages="form.errors.phone"
                  label="Номер"
                  :rules="[rules.required]"
                  :disabled="loading"
                  outlined
                  dense
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                v-model="form.name"
                :error-messages="form.errors.name"
                label="Имя"
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                v-model="form.surname"
                :error-messages="form.errors.surname"
                label="Фамилия"
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                v-model="form.middle_name"
                :error-messages="form.errors.middle_name"
                label="Отчество"
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                  v-model="form.email"
                  :error-messages="form.errors.email"
                  label="Email"
                  :disabled="loading"
                  outlined
                  dense
              />
            </v-col>
          </v-row>

          <v-row align="center">
            <v-col cols="12" sm="6" md="6" xl="6">
              <form-date-input
                v-model="form.date_of_birth"
                :label="'Дата рождения*'"
                :error-messages="form.errors.get(`date_of_birth`)"
              />
            </v-col>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-autocomplete
                v-model="form.citizenship"
                chips
                :items="citizenships"
                item-text="name"
                item-value="id"
                :label="'Гражданство'"
                :error-messages="form.errors.get(`citizenship`)"
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                v-model="form.passport_number"
                :error-messages="form.errors.passport_number"
                label="Серия и номер паспорта"
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>

            <v-col v-if="modelId" cols="12" sm="6" md="6" xl="6">
              <v-text-field
                  v-model="status"
                  label="Статус регистрации"
                  readonly
                  outlined
                  dense
              />
            </v-col>
          </v-row>

          <v-row>

            <v-col v-if="modelId" cols="12" sm="6" md="6" xl="6">
              <v-text-field
                  v-model="last_update"
                  label="Дата последнего обновления"
                  readonly
                  outlined
                  dense
              />
            </v-col>
          </v-row>

          <v-card-actions md="6">
            <v-btn v-if="modelId" type="submit" color="primary" :loading="form.busy">Обновить</v-btn>

            <v-btn v-else type="submit" color="primary" :loading="form.busy">Зарегистрировать</v-btn>

            <v-btn @click="$router.go(-1)">Отмена</v-btn>
          </v-card-actions>
        </v-card-text>

      </v-card>
    </v-form>
  </div>
</template>

<script>
import Form from 'vform'
import {$api} from "@/api";
import FormDateInput from "@/components/FormDateInput.vue";

export default {
  name: 'CourierForm',
  components: {FormDateInput},
  props: {
    modelId: {
      type: [String, Number],
      default: null
    }
  },
  data() {
    return {
      loading: false,
      errors: {},
      form: new Form({
        courier_partner_id: '',
        phone: '',
        email: '',
        name: '',
        surname: '',
        middle_name: '',
        date_of_birth: null,
        citizenship: '',
        passport_number: '',
      }),
      courier_partners: [],
      status: '',
      last_update: null,
      citizenships: [
        {
          id: 'domestic',
          name: 'Гражданин страны'
        },
        {
          id: 'foreign',
          name: 'Иностранный гражданин'
        },
        {
          id: 'unknown',
          name: 'Нет данных'
        },
      ],
      rules: {
        required: value => !!value || 'Обязательное поле'
      }
    }
  },
  async created() {
    await this.init()
  },
  methods: {
    async init() {
      try {
        this.loading = true

        const cabinetsResponse = await $api.cabinets.index()
        this.courier_partners = cabinetsResponse.data.data || []

        if (this.modelId) {
          const registration = (await $api.registrations.get(this.modelId))
          registration.data.data.courier_partner_id = registration.data.data.cabinet.courier_partner_id
          this.status = registration.data.data.status
          this.last_update = registration.data.data.updated_at
          this.form.fill(registration.data.data)
        }

      } catch (e) {
        this.error(e)
      } finally {
        this.loading = false
      }
    },
    error(error) {
      this.loading = false
      this.$toast.error(error.response.data.message)
    },
    async submit() {
      this.loading = true

      this.modelId
          ? await this.form.post($api.registrations.url.update(this.modelId))
              .then(() => this.$emit('submit'))
              .catch((error) => this.error(error))
          : await this.form.post($api.couriers.url.store())
              .then(() => this.$emit('submit'))
              .catch((error) => this.error(error))

      this.loading = false
    }
  }
}
</script>
