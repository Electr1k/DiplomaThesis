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
      this.$router.push({ name: 'users' })
      this.$toast.success(this.$t('saved'))
    }
  }
}
</script>
