import BaseApi from './BaseApi'

class AuthApi extends BaseApi {
  constructor () {
    super({ name: 'auth' })
    this.url = {
      login: () => `${this.apiUrl}/auth/login`,
    }
  }

}

export default AuthApi
