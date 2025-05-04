<template>
  <div>
    <v-form @submit.prevent="submit">
      <v-card
          :loading="loading"
          :disabled="loading"
      >
        <v-card-title class="display-1 mb-2">
          <span v-if="modelId">Данные сотрудника</span>
          <span v-else>Создание сотрудника</span>
        </v-card-title>

        <v-card-text>
          <v-row class="flex">
            <v-col md="4" align="center">
              <v-img
                  align="center"
                  v-if="photoUrl"
                  :src="photoUrl"
                  max-height="200"
                  max-width="200"
                  cover
                  class="mb-2 rounded-circle"
              ></v-img>
              <v-file-input
                  v-model="form.photo"
                  accept="image/*"
                  prepend-icon="mdi-camera"
                  label="Фото сотрудника"
                  :error-messages="errors.photo"
                  @change="handleFileUpload"
                  outlined
                  dense
              ></v-file-input>
            </v-col>
          </v-row>

          <v-row>
            <v-col md="6">
              <v-text-field
                v-model="form.name"
                :error-messages="errors.name"
                label="Имя*"
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>
            <v-col md="6">
              <v-text-field
                  v-model="form.surname"
                  :error-messages="errors.surname"
                  label="Фамилия*"
                  :rules="[rules.required]"
                  :disabled="loading"
                  outlined
                  dense
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col md="6">
              <v-text-field
                  v-model="form.middle_name"
                  :error-messages="errors.middle_name"
                  label="Отчество"
                  :disabled="loading"
                  outlined
                  dense
              />
            </v-col>
            <v-col md="6">
              <v-text-field
                  v-model="form.email"
                  :error-messages="errors.email"
                  label="Email*"
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
            :rules="[rules.required]"
            item-text="name"
            item-value="id"
            :label="'Роль*'"
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
                  :label="'Подтверждение пароля' + (modelId ? '' : ' *')"
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
        role_id: null,
        photo: null // Добавлено поле для фото
      }),
      photoUrl: null, // URL для предпросмотра фото
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

          // Если у пользователя уже есть фото, загружаем его для предпросмотра
          if (userResponse.image) {
            this.photoUrl = userResponse.image
          }
        }

      } catch (error) {
        console.error('Ошибка загрузки:', error)
        this.errors = error.response?.data?.errors || {}
      } finally {
        this.loading = false
      }
    },

    // Обработка загрузки файла
    handleFileUpload(file) {
      if (file) {
        // Создаем URL для предпросмотра
        this.photoUrl = URL.createObjectURL(file)
      } else {
        this.photoUrl = null
      }
    },

    error(error) {
      this.loading = false
      this.$toast.error(error.message)
    },

    async submit() {
      this.loading = true

      try {
        // Создаем FormData для отправки файла
        const formData = new FormData()

        // Добавляем все поля формы в FormData
        Object.keys(this.form.data()).forEach(key => {
          if (key === 'photo' && this.form.photo) {
            formData.append('photo', this.form.photo)
          } else if (this.form[key] !== null && this.form[key] !== undefined) {
            formData.append(key, this.form[key])
          }
        })

        if (this.modelId) {
          await $api.users.update(this.modelId, formData, {
              'Content-Type': 'multipart/form-data'
          })
        } else {
          await $api.users.store(formData, {
            'Content-Type': 'multipart/form-data'
          })
        }

        this.$emit('submit')
      } catch (error) {
        this.error(error)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
