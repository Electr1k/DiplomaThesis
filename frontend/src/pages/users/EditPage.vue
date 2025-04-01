  <template>
    <user-form
      :key="userId"
      :model-id="userId"
      @submit="onSubmit"
      @cancel="$router.back()"
    />
  </template>

  <script>
  import UserForm from '../../components/UserForm.vue'

  export default {
    components: {
      UserForm
    },
    data () {
      return {
        user: null,
        loading: false
      }
    },

    computed: {
      userId: function () {
        return this.$route.params.id
      }
    },

    methods: {
      onSubmit () {
        this.$toast.success('Данные успешно изменены')
        this.$router.push({ name: 'users' })
      }
    }
  }
  </script>
