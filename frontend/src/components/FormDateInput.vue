<template>
  <v-menu
    ref="menu"
    v-model="menu"
    :close-on-content-click="false"
    transition="scale-transition"
    offset-y
    min-width="290px"
  >
    <template #activator="{ on, attrs }">
      <v-text-field
        :value="formattedDate"
        readonly
        :error-messages="errorMessages"
        :label="label"
        v-bind="Object.assign(attrs, $attrs)"
        v-on="Object.assign(on, $listeners)"
        @click:clear="selected = null"
      >
        <template v-for="(_, slot) of $scopedSlots" #[slot]>
          <slot :name="slot" />
        </template>
      </v-text-field>
    </template>

    <v-date-picker
      v-model="selected"
      scrollable
      first-day-of-week="1"
      show-adjacent-months
      :min="minDate"
      @input="onInput"
    />
  </v-menu>
</template>

<script>

export default {
  name: 'FormDateInput',
  inheritAttrs: false,
  props: {
    value: {
      type: String,
      default: null
    },
    errorMessages: {
      type: String,
      default: null
    },
    min: {
      type: String,
      default: null
    },
    label: {
      type: String,
      default: () => ''
    }
  },
  data () {
    return {
      menu: false
    }
  },
  computed: {
    selected: {
      get () {
        console.log('value 32')
        return this.value ? this.$moment(this.value).format('YYYY-MM-DD') : null
      },
      set (value) {
        this.$emit('input', value)
      }
    },
    formattedDate: function () {
      return this.value ? this.$moment(this.value).format('DD.MM.YYYY') : null
    },
    minDate () {
      return this.min ? this.$moment(this.min, 'DD.MM.YYYY').format('YYYY-MM-DD') : '1950-01-01'
    }
  },
  methods: {
    onInput (value) {
      console.log("Value " + value)
      this.menu = false
      this.$emit('change', value)
    }
  }
}
</script>
