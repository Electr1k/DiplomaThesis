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
      this.$router.push({ name: 'roles' })
      this.$toast.success(this.$t('saved'))
    }
  }
}
</script>
