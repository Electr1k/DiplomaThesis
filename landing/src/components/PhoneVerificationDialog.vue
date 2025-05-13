<template>
  <v-dialog :value="internalValue" @input="updateValue" max-width="500" persistent>
    <v-card>
      <v-card-title class="headline pink white--text">
        Подтверждение номера телефона
      </v-card-title>

      <v-card-text class="pa-6">
        <p class="body-1 mb-6">
          Вам поступит звонок с кодом подтверждения на номер
          <strong>{{ formattedPhone }}</strong>.
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
              :disabled="resendDisabled"
              @click="resendCode"
          >
            Отправить код повторно {{ resendCountdown > 0 ? `(${resendCountdown})` : '' }}
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
      internalValue: this.value,
      code: '',
      loading: false,
      error: '',
      resendCountdown: 0,
      resendInterval: null
    }
  },
  watch: {
    value(newVal) {
      this.internalValue = newVal;
      if (newVal) {
        this.startResendCountdown();
      } else {
        this.clearResendCountdown();
      }
    }
  },

  computed: {
    formattedPhone() {
      return this.form.phone?.replace(/^(\+\d)(\d{3})(\d{3})(\d{2})(\d{2})$/, '$1 ($2) $3-$4-$5')
    },
    resendDisabled() {
      return this.resendCountdown > 0
    }
  },
  methods: {
    updateValue(newValue) {
      this.internalValue = newValue;
      this.$emit('input', newValue);
    },
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
        this.code = null
        this.close()
        this.$emit('error', e.response.data.message ?? 'Произошла ошибка')
      }
      finally {
        this.loading = false
      }
    },
    resendCode() {
      if (this.resendDisabled) return

      this.code = ''
      this.error = ''
      this.startResendCountdown()

      this.$toast.info('Код подтверждения отправлен повторно')
    },

    startResendCountdown() {
      this.resendCountdown = 60
      this.resendInterval = setInterval(() => {
        if (this.resendCountdown > 0) {
          this.resendCountdown--
        } else {
          this.clearResendCountdown()
        }
      }, 1000)
    },
    clearResendCountdown() {
      clearInterval(this.resendInterval)
      this.resendInterval = null
    },

    close() {
      this.code = ''
      this.error = ''
      this.loading = false
      this.updateValue(false)
      this.$emit('close')
    }
  },
  beforeDestroy() {
    this.clearResendCountdown()
  }
}
</script>
