import BaseApi from './BaseApi'
import axios from "axios";

class UserApi extends BaseApi {
  constructor () {
    super({ name: 'users' })
    this.url.getByToken = () => `${this.apiUrl}/users/get-by-token`
  }

  async getProfileByToken () {
    try {
      return await axios.get(this.url.getByToken(), this.getConfig())
    }
    catch (e) {
      if (e.response.status === 401) await this.refreshToken()
      else throw e
    }
  }

  async update(id, data, headers) {
    try {
      const config = this.getConfig()
      config.params = {...config.params, _method: 'PATCH'}
      if (headers) config.headers = {...config.headers, ...headers}

      console.log(config)
      return await axios.post(this.url.update(id), data, config)
    } catch (e) {
      await this.checkStatusResponse(e)
    }
  }

}

export default UserApi
