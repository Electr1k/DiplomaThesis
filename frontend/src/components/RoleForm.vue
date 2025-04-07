<template>
  <div>
    <v-form @submit.prevent="submit">
      <v-card
        :loading="loading"
        :disabled="loading"
      >
        <v-card-title class="display-1 mb-2">
          <span v-if="modelId">Изменение роли</span>
          <span v-else>Создание роли</span>
        </v-card-title>

        <v-card-text>
          <v-row>
            <v-col cols="12" sm="6" md="6" xl="6">
              <v-text-field
                v-model="form.name"
                :error-messages="errors.name"
                label="Название роли"
                :rules="[rules.required]"
                :disabled="loading"
                outlined
                dense
              />
            </v-col>
          </v-row>

          <v-simple-table>
            <template>
              <thead>
              <tr>
                <th class="text-left">Название</th>
                <th
                  style="width: 30%"
                  class="text-left"
                >
                  <div class="d-inline-flex">
                    <v-checkbox v-model="allPermissions" @click="setAllPermissions" />
                    <span class="mt-6">Установить все разрешения</span>
                  </div>
                </th>
                <th class="text-left">Есть</th>
              </tr>
              </thead>
              <tbody>
              <tr
                v-for="(permission, index) in permissions" :key="index"
              >
                <td>{{ permission.name }}</td>
                <td></td>
                <td><v-checkbox :value="form.permissions.includes(permission.code)" @click="setPermission(permission.code)"/></td>
              </tr>
              </tbody>
            </template>
          </v-simple-table>
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
        permissions: []
      }),
      permissions: [],
      allPermissions: false,
      maps: [],
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

        const permissionsResponse = await $api.permissions.index()
        this.permissions = permissionsResponse.data.data || []

        if (this.modelId) {
          const roleResponse = (await $api.roles.get(this.modelId))
          roleResponse.data.data.permissions = roleResponse.data.data.permissions.map((permission) => permission.code)

          this.form.fill(roleResponse.data.data)
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
      console.log(this.form)

      this.modelId
        ? await $api.roles.update(this.modelId, this.form.data())
          .then(() => this.$emit('submit'))
          .catch((error) => this.error(error))
        : await $api.roles.store(this.form.data())
          .then(() => this.$emit('submit'))
          .catch((error) => this.error(error))

      this.loading = false
    },
    setAllPermissions () {
      this.form.permissions = this.permissions.map((permission) => permission.code)

      if (!this.allPermissions) {
        this.form.permissions = []
      }
    },
    setPermission (id) {
      this.form.permissions.includes(id) ? this.form.permissions.splice(this.form.permissions.indexOf(id), 1) : this.form.permissions.push(id)
    }
  }
}
</script>
