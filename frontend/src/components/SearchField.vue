<template>
  <v-text-field
    v-model.trim="search"
    v-bind="$attrs"
    dense
    solo
    hide-details
    prepend-inner-icon="mdi-magnify"
    label="Поиск"
    placeholder="Введите текст для поиска"
    clearable
    v-on="$listeners"
  >
    <template v-for="(_, slot) of $scopedSlots" #[slot]>
      <slot :name="slot" />
    </template>
  </v-text-field>
</template>

<script>

export default {
  name: 'SearchField',
  props: {
    value: {
      type: String,
      default: null
    }
  },
  computed: {
    search: {
      get () {
        return this.value
      },
      set (value) {
        this.$emit('input', value)
      }
    }
  }
}
</script>
