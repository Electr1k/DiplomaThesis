<template>
  <v-app>
    <v-main>
      <v-container class="landing-container">
        <v-row justify="center">
          <v-col cols="12" md="8" class="text-center">
            <v-img
                :src="require('./assets/img.png')"
                contain
                height="80"
                class="mx-auto"
            ></v-img>
            <h1 class="mt-5 mb-3 display-1 font-weight-bold pink--text">
              Станьте курьером Достависты
            </h1>
            <p class="subtitle-1 grey--text text--darken-1">
              Зарабатывайте до 150 000 ₽ в месяц с гибким графиком
            </p>
          </v-col>
        </v-row>

        <v-row justify="center" align="center">
          <v-col cols="12" md="6" class="pr-md-10">
            <v-card flat class="transparent">
              <v-card-text>
                <div>
                  <p class="text-subtitle-1	">
                    <span class="pink--text text-h6	font-weight-bold">Достависта</span> - это сервис доставки, который объединяет тысячи заказов ежедневно.
                    Присоединяйтесь к нашей команде и получайте стабильный доход с возможностью
                    выбирать удобные для вас заказы.
                  </p>
                </div>

                <h2 class="mb-4 headline font-weight-bold">
                  Почему курьеры выбирают Достависту?
                </h2>

                <v-list dense class="transparent">
                  <v-list-item v-for="(benefit, i) in benefits" :key="i">
                    <v-list-item-icon>
                      <v-icon color="pink">mdi-check-circle</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                      <v-list-item-title>{{ benefit }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>

          <v-col cols="12" md="6">
            <v-card class="elevation-6 rounded-lg">
              <v-card-title class="headline pink white--text">
                Оставьте заявку
              </v-card-title>
              <v-card-text class="pa-6">
                <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="submit">
                  <v-text-field
                      v-model="form.surname"
                      label="Фамилия"
                      required
                      outlined
                      prepend-inner-icon="mdi-account"
                  ></v-text-field>

                  <v-text-field
                      v-model="form.name"
                      label="Имя"
                      required
                      outlined
                      prepend-inner-icon="mdi-account"
                  ></v-text-field>

                  <v-text-field
                      v-model="form.middle_name"
                      label="Отчество"
                      outlined
                      prepend-inner-icon="mdi-account"
                  ></v-text-field>

                  <v-text-field
                      v-model="form.phone"
                      :rules="phoneRules"
                      label="Номер телефона"
                      required
                      outlined
                      prepend-inner-icon="mdi-phone"
                  ></v-text-field>

                  <v-select
                      :items="citizenships"
                      :value="form.citizenship"
                      @change="(item) => form.citizenship = item"
                      outlined
                      item-text="name"
                      item-value="value"
                      label="Гражданство"
                  >
                    <template v-slot:item="{ item }">
                      <v-list-item-title>
                        {{ item.name }}
                      </v-list-item-title>
                    </template>
                  </v-select>

                  <v-btn
                      type="submit"
                      block
                      x-large
                      color="green"
                      class="white--text mt-4"
                      :disabled="!valid"
                  >
                    Оставить заявку
                  </v-btn>
                </v-form>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>

        <phone-verification-dialog
            v-model="showVerificationDialog"
            :form="form"
            @verified="onVerified"
            @error="onError"
            @close="showVerificationDialog = false"
        />
      </v-container>
    </v-main>

  </v-app>
</template>

<script>
import PhoneVerificationDialog from './components/PhoneVerificationDialog.vue'
import axios from 'axios'
import './plugins/toastification'
import Form from 'vform'

export default {
  components: {
    PhoneVerificationDialog
  },
  data: () => ({
    valid: true,
    form: new Form({
      name: null,
      surname: null,
      middle_name: null,
      courier_partner_id: null,
      citizenship: null,
      code: null
    }),
    citizenships: [{name: 'Гражданин страны', value: 'domestic'}, {name: 'Иностранный гражданин', value: 'foreign'}, {name: 'Неизвестно', value: 'unknown'},],

    phoneRules: [
      v => !!v || 'Укажите номер телефона',
      v => (v && v.replace(/\D/g, '').length === 11) || 'Номер должен содержать 11 цифр'
    ],
    showVerificationDialog: false,
    benefits: [
      'Высокие ставки за доставку',
      'Гибкий график работы',
      'Выплаты ежедневно или по запросу',
      'Бонусы за рейтинг и активность',
      'Поддержка 24/7',
      'Работа в своем районе или по всему городу'
    ]
  }),
  methods: {
    async submit() {
      if (this.$refs.form.validate()) {
        try {
          await axios.post('http://localhost:8080/api/v1/public/verify-phone', { phone: this.form.phone })
          this.showVerificationDialog = true
        }
        catch (e) {
          console.log(e.response)
          this.$toast.error(e.response.data.message ?? 'Произошла ошибка')
        }
      }
    },
    onVerified() {
      this.showVerificationDialog = false
      this.form.reset()
      this.$vuetify.goTo(0, { duration: 300, easing: 'easeInOutCubic' })
      this.$toast.success('Ваша заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.')
    },
    onError(message) {
      this.showVerificationDialog = false

      this.$toast.error(message)
    },
  }
}
</script>

<style scoped>
.landing-container {
  max-width: 1200px;
  padding-top: 40px;
  padding-bottom: 80px;
}

</style>
