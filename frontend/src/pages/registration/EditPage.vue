<template>
  <courier-form
      :model-id="registrationId"
      @submit="onSubmit"
      @cancel="$router.back()"
  />
</template>

<script>
import CourierForm from "@/components/CourierForm.vue";

export default {
  components: {
    CourierForm
  },
  data () {
    return {
      user: null,
      loading: false
    }
  },

  computed: {
    registrationId: function () {
      return this.$route.params.id
    }
  },

  methods: {
    onSubmit () {
      this.$toast.success('Регистрация обновлена')
      this.$router.push({ name: 'registrations' })
    }
  }
}
</script>
