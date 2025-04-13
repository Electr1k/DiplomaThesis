<template>
  <courier-form
    @submit="onSubmit"
    @cancel="$router.back()"
  />
</template>

<script>
import CourierForm from '../../components/CourierForm'

export default {
  name: 'CreatePage',
  components: {
    CourierForm
  },
  methods: {
    onSubmit () {
      this.$router.push({ name: 'registrations' })
      this.$toast.success("Клиент добавлен в очередь на создание")
    }
  }
}
</script>
