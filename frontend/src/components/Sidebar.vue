<template>
  <v-navigation-drawer v-model="internalDrawer" app>
    <v-img
        height="140"
        class="pa-4"
    >
      <div class="text-center">
        <v-avatar class="mb-4" color="grey darken-1" size="64">
          <v-img
              aspect-ratio="30"
          />
        </v-avatar>
        <h2 class="black--text">Current user</h2>
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
      links: [
        { icon: "mdi-security", text: "Роли", route: "roles" },
        { icon: "mdi-account-box", text: "Сотрудники", route: "users" },
        { icon: "mdi-certificate", text: "Кабинеты партнеров", route: "cabinets" },
        { icon: "mdi-card-account-details-outline", text: "Клиенты", route: "couriers" },
        { icon: "mdi-clipboard-list-outline", text: "Регистрации", route: "registrations" },
        { icon: "mdi-book-open-variant", text: "Сводный отчет", route: "summary" },
      ],
    };
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
