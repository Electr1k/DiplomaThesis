import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import channel from "@/plugins/echo";

Vue.config.productionTip = false
channel.bind('NotificationSent', (data) => {
    Vue.prototype.$toast?.info?.(data.message || data);
});

new Vue({
  vuetify,
  router,
  render: h => h(App)
}).$mount('#app')
