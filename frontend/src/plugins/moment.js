import Vue from 'vue'
import moment from 'moment-timezone'

Vue.prototype.$moment = (args) => {
  return moment(args).locale('ru')
}
