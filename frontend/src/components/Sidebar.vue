<template>
  <v-navigation-drawer v-model="internalDrawer" app>
    <v-img
        height="140"
        class="pa-4"
        src="https://preview.pixlr.com/images/800wm/1439/2/1439104804.jpg"
    >
      <div class="text-center">
        <v-avatar class="mb-4" color="grey darken-1" size="64">
          <v-img
              aspect-ratio="30"
              src="https://yt3.ggpht.com/esazPAO03T0f0vKdByJvkDy6MSwjyG5f-c_2S2CJapszQ3KPQyZarpoqvgv0Us0atUbILytj=s88-c-k-c0x00ffffff-no-rj"
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
        { icon: "mdi-microsoft-windows", text: "Роли", route: "roles" },
        { icon: "mdi-account", text: "Сотрудники", route: "users" },
        { icon: "mdi-clipboard-list-outline", text: "Клиенты", route: "couriers" },
        { icon: "mdi-clipboard-list-outline", text: "Регистрации", route: "registrations" },
        { icon: "mdi-card-account-details-outline", text: "Отчеты", route: "reports" },
        { icon: "mdi-cog", text: "System Setting", route: "settings" },
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

<style scoped>
/* Стиль для активного пункта меню */
.v-list-item--active {
  background-color: rgba(0, 0, 0, 0.04);
}
</style>
