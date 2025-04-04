<template>
  <role-form
    @submit="onSubmit"
    @cancel="$router.back()"
  />
</template>

<script>
import RoleForm from '../../components/RoleForm'

export default {
  name: 'CreatePage',
  components: {
    RoleForm
  },
  methods: {
    onSubmit () {
      this.$toast.success('Роль успешно создана')
      this.$router.push({ name: 'roles' })
    }
  }
}
</script>
