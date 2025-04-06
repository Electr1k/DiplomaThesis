<template>
  <div class="wrapper fadeInDown">
    <div id="formContent" class="auth-card">
      <form @submit.prevent="handleLogin">
        <div class="fadeIn first">
          <p class="auth-title">Авторизация</p>
        </div>
        <input
            v-model="form.email"
            type="text"
            class="fadeIn second auth-input"
            placeholder="Email"
        />
        <input
            v-model="form.password"
            type="password"
            class="fadeIn third auth-input"
            placeholder="Пароль"
        />
        <input
            type="submit"
            class="fadeIn fourth auth-submit"
            value="Войти"
        />
      </form>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import {$api} from "@/api";

export default {
  name: "AuthForm",
  data() {
    return {
      form: new Form({
        email: '',
        password: '',
      }),
    };
  },
  methods: {
    async handleLogin() {
      await this.form.post($api.auth.url.login())
          .then((data) => {
            this.$toast.success('Вы авторизованы')
            localStorage.setItem('auth_token', data.data.access_token);
            this.$router.push({ name: 'dashboard'})
          })
          .catch((error) => {
            this.$toast.error(error.response.status === 401 ? 'Неверный логин или пароль' : 'Произошла ошибка')
          })
    },
  },
};
</script>

<style scoped>
body {
  font-family: "Poppins", sans-serif;
  height: 100vh;
}

.wrapper {
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  width: 100%;
  min-height: 100%;
  padding: 20px;
}

#formContent {
  border-radius: 10px 10px 10px 10px;
  background: #fff;
  width: 90%;
  max-width: 450px;
  position: relative;
  padding: 0;
  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  text-align: center;
}

.auth-title {
  padding-top: 20px;
  font-size: 24px;
  margin-bottom: 30px;
}

.auth-input {
  background-color: #f6f6f6;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  width: 85%;
  border: 2px solid #f6f6f6;
  -webkit-transition: all 0.5s ease-in-out;
  -moz-transition: all 0.5s ease-in-out;
  -ms-transition: all 0.5s ease-in-out;
  -o-transition: all 0.5s ease-in-out;
  transition: all 0.5s ease-in-out;
  border-radius: 5px 5px 5px 5px;
}

.auth-input:focus {
  outline: none !important;
  background-color: #fff;
  border-bottom: 2px solid #5fbae9;
}

.auth-input::placeholder {
  color: #cccccc;
}

.auth-submit {
  background-color: #56baed;
  border: none;
  color: white;
  padding: 15px 80px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  text-transform: uppercase;
  font-size: 13px;
  box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  border-radius: 5px 5px 5px 5px;
  margin: 5px 20px 40px 20px;
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -ms-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
  cursor: pointer;
}

.auth-submit:hover {
  background-color: #39ace7;
  -ms-transform: scale(1.05);
  transform: scale(1.05);
}

.auth-submit:focus {
  outline: none !important;
  background-color: #39ace7;
  -ms-transform: scale(1.05);
  transform: scale(1.05);
}


.fadeInDown {
  animation-name: fadeInDown;
  animation-duration: 1s;
  animation-fill-mode: both;
}

@-webkit-keyframes fadeInDown {
  0% {
    opacity: 0;
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    transform: none;
  }
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    transform: none;
  }
}

.fadeIn {
  opacity: 0;
  -webkit-animation: fadeIn ease-in 1;
  -moz-animation: fadeIn ease-in 1;
  animation: fadeIn ease-in 1;
  -webkit-animation-fill-mode: forwards;
  -moz-animation-fill-mode: forwards;
  animation-fill-mode: forwards;
  -webkit-animation-duration: 1s;
  -moz-animation-duration: 1s;
  animation-duration: 1s;
}

.fadeIn.first {
  -webkit-animation-delay: 0.4s;
  -moz-animation-delay: 0.4s;
  animation-delay: 0.4s;
}

.fadeIn.second {
  -webkit-animation-delay: 0.6s;
  -moz-animation-delay: 0.6s;
  animation-delay: 0.6s;
}

.fadeIn.third {
  -webkit-animation-delay: 0.8s;
  -moz-animation-delay: 0.8s;
  animation-delay: 0.8s;
}

.fadeIn.fourth {
  -webkit-animation-delay: 1s;
  -moz-animation-delay: 1s;
  animation-delay: 1s;
}

@-webkit-keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
@-moz-keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
