<template>
  <v-dialog :value="visible" max-width="500" persistent>
    <v-card>
      <v-card-title class="headline pink white--text">
        Подтверждение номера телефона
      </v-card-title>

      <v-card-text class="pa-6">
        <p class="body-1 mb-6">
          Вам поступит СМС с кодом подтверждения на номер
          <strong>{{ this.form.phone?.replace(/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/, '$1 ($2) $3-$4-$5') }}</strong>.
          Введите полученный код ниже:
        </p>

        <v-otp-input
            v-model="code"
            length="4"
            type="number"
            :disabled="loading"
            @finish="verifyCode"
        ></v-otp-input>

        <div>
          <v-btn
              text
              x-small
              color="orange darken-2"
              :disabled="this.secondsReset > 0"
              @click="resendCode"
          >
            Отправить код повторно {{ secondsReset > 0 ? `(${secondsReset})` : '' }}
          </v-btn>
        </div>

        <v-alert
            v-if="error"
            dense
            outlined
            type="error"
            class="mt-4"
        >
          {{ error }}
        </v-alert>
      </v-card-text>

      <v-card-actions class="pb-4">
        <v-spacer></v-spacer>
        <v-btn
            text
            @click="close"
        >
          Отмена
        </v-btn>
        <v-btn
            color="green darken-2"
            :loading="loading"
            :disabled="code.length < 4"
            @click="verifyCode"
        >
          Подтвердить
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from "axios";
import Form from "vform";

export default {
  props: {
    value: Boolean,
    form: Form
  },
  data() {
    return {
      visible: this.value,
      code: '',
      loading: false,
      error: '',
      secondsReset: 0,
      resendInterval: null
    }
  },
  watch: {
    value(newVal) {
      this.visible = newVal;
      if (newVal) {
        this.startResendCountdown();
      } else {
        this.resendInterval = null;
      }
    }
  },

  methods: {
    async verifyCode() {
      if (this.code.length < 4) return
      this.error = ''
      this.loading = true
      this.$props.form.code = this.code

      try {
        await axios.post('http://localhost:8080/api/v1/public/registration', this.form.data())

        this.$emit('verified')
      }
      catch (e) {
        if (e.response.data.message !== 'Неверный код') {
          this.close()
          this.$emit('error', e.response.data.message ?? 'Произошла ошибка')
        }
        else {
          this.error = 'Неверный код'
        }
      }
      finally {
        this.code = ""
        this.loading = false
      }
    },
    resendCode() {
      if (this.secondsReset > 0) return

      this.code = ''
      this.error = ''
      this.startResendCountdown()

      this.$toast.info('Код подтверждения отправлен повторно')
    },

    startResendCountdown() {
      this.secondsReset = 60
      this.resendInterval = setInterval(() => {
        if (this.secondsReset > 0) {
          this.secondsReset--
        } else {
          this.resendInterval = null
        }
      }, 1000)
    },

    close() {
      this.code = ''
      this.error = ''
      this.loading = false
      this.visible = false
      this.$emit('close')
    }
  },
}
</script>
