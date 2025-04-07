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

}

export default UserApi
