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
                      :rules="requiredRules"
                      label="Фамилия"
                      outlined
                      prepend-inner-icon="mdi-account"
                  ></v-text-field>

                  <v-text-field
                      v-model="form.name"
                      :rules="requiredRules"
                      label="Имя"
                      outlined
                      prepend-inner-icon="mdi-account"
                  ></v-text-field>

                  <v-select
                      :items="cabinets"
                      v-model="form.courier_partner_id"
                      :rules="requiredRules"
                      outlined
                      :item-text="item => `${item.region_name} (${item.vehicle_type_name})`"
                      item-value="courier_partner_id"
                      label="Город"
                  >
                    <template v-slot:item="{ item }">
                      <v-list-item-title>
                        {{ `${item.region_name} (${item.vehicle_type_name})` }}
                      </v-list-item-title>
                    </template>

                  </v-select>
                  <v-text-field
                      v-model="formated_phone"
                      :rules="phoneRules"
                      label="Номер телефона"
                      outlined
                      single-line
                      @input="formatPhone()"
                      prepend-inner-icon="mdi-phone"
                      maxlength="17"
                  ></v-text-field>

                  <v-select
                      :items="citizenships"
                      v-model="form.citizenship"
                      :rules="requiredRules"
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
    baseUrl: 'http://localhost:8080',
    valid: true,
    form: new Form({
      name: null,
      surname: null,
      middle_name: null,
      courier_partner_id: null,
      citizenship: null,
      code: null
    }),
    formated_phone: "",
    citizenships: [{name: 'Гражданин страны', value: 'domestic'}, {name: 'Иностранный гражданин', value: 'foreign'}, {name: 'Неизвестно', value: 'unknown'},],
    cabinets: [],
    requiredRules: [v => !!v || "Обязательное поле"], // Правило для обязательных полей
    phoneRules: [
      v => !!v || 'Укажите номер телефона',
      v => v.length === 17 || "Номер должен состоять из 11 цифр"
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
  async created() {
    try {
      const response = await axios.get(`${this.baseUrl}/api/v1/public/cabinets`);
      if (response.data && response.data.data) {
        this.cabinets = response.data.data
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
  },
  methods: {
    async submit() {
      if (this.$refs.form.validate()) {
        try {
          await axios.post(`${this.baseUrl}/api/v1/public/verify-phone`, {phone: this.form.phone})
          this.showVerificationDialog = true
          console.log(this.form.phone)
        } catch (e) {
          this.$toast.error(e.response.data.message ?? 'Произошла ошибка')
        }
      }
    },
    onVerified() {
      this.showVerificationDialog = false
      this.form.reset();
      this.formated_phone = ""
      this.$refs.form.resetValidation();

      this.$toast.success('Ваша заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.')
    },
    onError(message) {
      this.$toast.error(message)
    },
    formatPhone() {
      let phone = this.formated_phone.replace(/\D/g, '');

      if (phone.length > 0 && phone[0] !== '7') {
        phone = '7' + phone.slice(1);
      }
      phone = phone.substring(0, 11);

      this.form.phone = phone;

      if (phone.length > 0) {
        const match = phone.match(/^(\d{1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})$/);
        if (match) {
          this.formated_phone = [
            match[1],
            match[2] ? ' (' + match[2] : '',
            match[3] ? ') ' + match[3] : '',
            match[4] ? '-' + match[4] : '',
            match[5] ? '-' + match[5] : ''
          ].join('');
        }
      }
    }
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
