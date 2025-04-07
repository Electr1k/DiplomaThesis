import BaseApi from './BaseApi'
import axios from "axios";

class AuthApi extends BaseApi {
  constructor () {
    super({ name: 'auth' })
    this.url = {
      login: () => `${this.apiUrl}/auth/login`,
      refresh: () => `${this.apiUrl}/auth/refresh`
    }
  }

  refresh() {
    return axios.get(this.url.refresh(), this.getConfig())
  }
}

export default AuthApi
