<template>
  <div>
    <v-form @submit.prevent="submit">
      <v-card
        :loading="loading"
        :disabled="loading"
      >
        <v-card-title class="display-1 mb-2">
          <span v-if="modelId">Изменение данных сотрудника</span>
          <span v-else>Создание сотрудника</span>
        </v-card-title>

        <v-card-text>
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
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>
          </v-row>

          <v-autocomplete
            v-model="form.role_id"
            chips
            :items="roles"
            item-text="name"
            item-value="id"
            :label="'Роль'"
            :error-messages="form.errors.get(`role_id`)"
          />

          <v-row>
            <v-col cols="9">
              <div class="d-flex justify-space-around">
                <v-text-field
                  v-model="form.password"
                  class="mr-2"
                  :rules="(modelId ? [] : [rules.required])"
                  :type="showPassword ? 'text' : 'password'"
                  :label="'Пароль' + (modelId ? '' : ' *')"
                  :error-messages="form.errors.get(`password`)"
                  name="password"
                  outlined
                  dense
                />
                <v-text-field
                  v-model="form.password_confirmation"
                  class="ml-2"
                  :rules="(modelId ? [] : [rules.required])"
                  :type="showPassword ? 'text' : 'password'"
                  :label="'Пароль' + (modelId ? '' : ' *')"
                  :error-messages="form.errors.get(`password_confirmation`)"
                  outlined
                  dense
                />
              </div>
              <v-row>
                <v-col>
                  <v-checkbox
                    v-model="showPassword"
                    :label="'Показать пароль'"
                    class="mt-0"
                    @click:append="showPassword = !showPassword"
                  />
                </v-col>
              </v-row>
            </v-col>
          </v-row>

        </v-card-text>

        <v-card-actions>
          <v-btn type="submit" color="primary" :loading="loading">
            Сохранить
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

export default {
  name: 'RoleForm',
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
        name: '',
        surname: '',
        middle_name: null,
        email: '',
        password: '',
        password_confirmation: '',
        role_id: null
      }),
      roles: [],
      showPassword: false,
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

        const rolesResponse = await $api.roles.index()
        this.roles = rolesResponse.data.data || []

        if (this.modelId) {
          const userResponse = (await $api.users.get(this.modelId)).data.data
          this.form.fill({
            name: userResponse.name,
            surname: userResponse.surname,
            middle_name: userResponse.middle_name,
            email: userResponse.email,
            role_id: userResponse.role.id,
          })
        }

      } catch (error) {
        console.error('Ошибка загрузки:', error)
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

      this.modelId
        ? await $api.users.update(this.modelId, this.form.data())
          .then(() => this.$emit('submit'))
          .catch((error) => this.error(error))
        : await $api.users.store(this.form.data())
          .then(() => this.$emit('submit'))
          .catch((error) => this.error(error))

      this.loading = false
    }
  }
}
</script>
