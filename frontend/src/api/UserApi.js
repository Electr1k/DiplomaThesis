import BaseApi from './BaseApi'
import axios from "axios";

class UserApi extends BaseApi {
  constructor () {
    super({ name: 'users' })
    this.url.getByToken = () => `${this.apiUrl}/users/get-by-token`
  }

  getProfileByToken () {
    return axios.get(this.url.getByToken(), this.config)
  }

}

export default UserApi
