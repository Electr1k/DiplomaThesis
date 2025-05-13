import BaseApi from './BaseApi'
import axios from "axios";

class RegistrationCourierApi extends BaseApi {
  constructor () {
    super({ name: 'couriers/registrations' })
    this.url.close = (id) => `${this.apiUrl}/couriers/registrations/${id}/close`
  }

  async close(id) {
    return await axios.get(this.url.close(id), {...this.getConfig() })
  }
}

export default RegistrationCourierApi
