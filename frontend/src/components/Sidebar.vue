<template>
  <v-navigation-drawer v-model="internalDrawer" app>
    <v-img
        class="pa-4"
    >
      <div class="text-center">
        <v-avatar class="mb-4" color="grey darken-1" size="64">
          <v-img
              aspect-ratio="30"
          />
        </v-avatar>
        <h2 class="black--text">{{ this.user_name }}</h2>
        <v-btn text color="red" x-small @click="logout">Выйти</v-btn>
      </div>
    </v-img>
    <v-divider></v-divider>
    <v-list>
      <v-list-item
          v-for="(item, index) in links"
          :key="index"
          link
          :to="{ name: item.route }"
          active-class="primary--text"
          :exact="item.route === 'dashboard'"
      >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>{{ item.text }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import {$api} from "@/api";
import router from "@/router";

export default {
  name: "TheSidebar",
  props: {
    drawer: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      user_name: '',
      links: [
        { icon: "mdi-view-dashboard-outline", text: "Главная", route: "dashboard" },
        { icon: "mdi-security", text: "Роли", route: "roles" },
        { icon: "mdi-account-box", text: "Сотрудники", route: "users" },
        { icon: "mdi-certificate", text: "Кабинеты партнеров", route: "cabinets" },
        { icon: "mdi-card-account-details-outline", text: "Клиенты", route: "couriers" },
        { icon: "mdi-clipboard-list-outline", text: "Регистрации", route: "registrations" },
        { icon: "mdi-account-minus-outline", text: "Неактивные клиенты", route: "inactive-couriers" },
        { icon: "mdi-book-open-variant", text: "Сводный отчет", route: "summary" },
      ],
    };
  },
  async created() {
    await this.init()
  },
  methods: {
    async init() {
      try {
        const user = await $api.users.getProfileByToken()
        this.user_name = `${user.data.data.name} ${user.data.data.surname}`
      } catch (error) {
        console.error('Ошибка загрузки:', error)
      }
    },
    logout() {
      localStorage.removeItem('auth_token')
      router.push({ name: 'login'})
    }
  },
  computed: {
    internalDrawer: {
      get() {
        return this.drawer;
      },
      set(value) {
        this.$emit('update:drawer', value);
      }
    }
  }
};
</script>
