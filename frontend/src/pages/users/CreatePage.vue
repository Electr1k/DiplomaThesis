<template>
  <user-form
    @submit="onSubmit"
    @cancel="$router.back()"
  />
</template>

<script>
import UserForm from '../../components/UserForm'

export default {
  name: 'CreatePage',
  components: {
    UserForm
  },
  methods: {
    onSubmit () {
      this.$toast.success('Сотрудник успешно создан')
      this.$router.push({ name: 'couriers' })
    }
  }
}
</script>
