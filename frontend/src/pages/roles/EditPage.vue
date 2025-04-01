  <template>
    <role-form
      :key="roleId"
      :model-id="roleId"
      @submit="onSubmit"
      @cancel="$router.back()"
    />
  </template>

  <script>
  import RoleForm from '../../components/RoleForm'

  export default {
    components: {
      RoleForm
    },
    data () {
      return {
        user: null,
        loading: false
      }
    },

    computed: {
      roleId: function () {
        return this.$route.params.id
      }
    },

    methods: {
      onSubmit () {
        this.$toast.success('Роль успешна изменена')
        this.$router.push({ name: 'roles' })
      }
    }
  }
  </script>
