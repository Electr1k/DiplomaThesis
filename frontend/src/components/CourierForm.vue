<template>
  <div>
    <v-form @submit.prevent="submit">
      <v-card
        :loading="loading"
        :disabled="loading"
      >
        <v-card-title class="display-1 mb-2">Создание курьера</v-card-title>

        <v-autocomplete
          v-model="form.courier_partner_id"
          chips
          :items="courier_partners"
          item-text="region_name"
          item-value="courier_partner_id"
          :label="'Кабинет патнера'"
          :error-messages="form.errors.get(`courier_partner_id`)"
        />

        <v-card-text>
          <v-row>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                v-model="form.phone"
                :error-messages="errors.phone"
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
                v-model="form.email"
                :error-messages="errors.email"
                label="Email"
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
                :error-messages="errors.name"
                label="Имя"
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
                v-model="form.surname"
                :error-messages="errors.surname"
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
                :error-messages="errors.middle_name"
                label="Отчество"
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>
          </v-row>

          <form-date-input
            v-model="form.date_of_birth"
            :label="'Дата рождения*'"
            :error-messages="form.errors.get(`date_of_birth`)"
          />

          <v-autocomplete
            v-model="form.citizenship"
            chips
            :items="citizenships"
            item-text="name"
            item-value="id"
            :label="'Гражданство'"
            :error-messages="form.errors.get(`citizenship`)"
          />

          <v-row>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                v-model="form.passport_number"
                :error-messages="errors.passport_number"
                label="Серия и номер паспорта"
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>
          </v-row>

        </v-card-text>

        <v-card-actions>
          <v-btn type="submit" color="primary" :loading="form.busy">
            Зарегистрировать
          </v-btn>
          <v-btn @click="$router.go(-1)">Отмена</v-btn>
        </v-card-actions>
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

      } catch (error) {
        this.errors = error.response?.data?.errors || {}
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

      await this.form.post($api.couriers.url.store())
          .then(() => this.$emit('submit'))
          .catch((error) => this.error(error))

      this.loading = false
    }
  }
}
</script>
