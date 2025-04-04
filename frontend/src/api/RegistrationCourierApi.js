import BaseApi from './BaseApi'

class RegistrationCourierApi extends BaseApi {
  constructor () {
    super({ name: 'couriers/registrations' })
  }
}

export default RegistrationCourierApi
